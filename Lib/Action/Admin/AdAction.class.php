<?php
class AdAction extends AdminBaseAction {
	
	public function index(){
		$Ad=M("Ad");
		$adList=$Ad->where("state=1 or state=0")->order('id desc')->select();
		$this->assign("adList", $adList);
		
		$adArr = adArray();
		$this->assign("adArr",$adArr);//广告类型
		
		$this->display( APP_PATH.'/Tpl/default/Admin/ad/list.html');
	}
	
/**
	 * 跳转到新增自定义的页面
	 */
	public function add(){
		$this->display(APP_PATH.'/Tpl/default/Admin/ad/add.html');
	}
	
	function insert(){
		import('ORG.Net.UploadFile');
		//先增加记录
		$Ad=M("ad");
		$Ad->create();
		//$Ad->headPic = $info[0]['savename']; // 保存上传的照片根据需要自行组装
		

		//dump($Ad);
		//return;
		$id = $Ad->add();
		if(!$id){
			$this->error("写入数据失败");
		}
			
		if(is_uploaded_file($_FILES['banner']['tmp_name'])) {//如果选择上传文件
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  'Public/Uploads/ad/'.date("Ymd").'/';// 设置附件上传目录
			$upload->uploadReplace = true;
			$upload->saveRule = 'uniqid';//文件名规则
	//		$upload->thumb = true;
	//	    $upload->thumbMaxWidth = '50,200';
	//	    $upload->thumbMaxHeight = '50,200';
			try{
				if(!$upload->upload()) {// 上传错误提示错误信息
					$this->error($upload->getErrorMsg());
				}else{// 上传成功 获取上传文件信息
					$info =  $upload->getUploadFileInfo();
					$Ad->path='/Public/Uploads/ad/'.date("Ymd").'/'.$info[0]['savename'];//图片路径.
				}
			}catch(Exception $e){
				echo $e;
			}
		}
		
		$Ad->id=$id;
		$Ad->save();
		
		$this->redirect("index") ;//重定向到列表方法。
		
	}
	
	// 删除数据
	public function delete() {
		if(!empty($_GET['id'])) {
			$Ad	=	M("ad");
			$Ad->id=$_GET['id'];
			$Ad->state=-1;
			$result	=	$Ad->save();
			if(false !== $result) {
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	//编辑数据 | 跳到更新页面
	public function edit() {
		if(!empty($_GET['id'])) {
			$Ad	=	M("ad");
			$vo	=	$Ad->where("state=1")->select($_GET['id']);
			//$vo	=	$Form->getById($_GET['id']);
			//echo $vo[0];
			//dump($vo);
			if($vo && $vo[0]) {
				$this->assign('vo',$vo[0]);
				$this->display(APP_PATH.'/Tpl/default/Admin/ad/edit.html');
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
	}
	
	// 更新数据
	public function update() {
		import('ORG.Net.UploadFile');
		if (empty($_POST['id'])){
			$this->error("编辑失败，缺少主键ID");
			return;
		}
		
		$picPath = null;
		$info = null;
		if(is_uploaded_file($_FILES['path']['tmp_name'])) {//如果选择上传文件
			
			try {
				$upload = new UploadFile();// 实例化上传类
				$upload->maxSize  = 3145728 ;// 设置附件上传大小
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				$upload->savePath =  'Public/Uploads/ad/'.date("Ymd").'/';// 设置附件上传目录
				$upload->uploadReplace = true;
				$upload->saveRule = 'uniqid';//文件名规则
		//		$upload->thumb = true;
		//	    $upload->thumbMaxWidth = '50,200';
		//	    $upload->thumbMaxHeight = '50,200';
				if(!$upload->upload()) {// 没有选择上传图片
					
				}else{// 上传成功 获取上传文件信息
					$info =  $upload->getUploadFileInfo();
					//echo "dump".dump($info);
					$picPath = '/Public/Uploads/ad/'.date("Ymd").'/'.$info[0]['savename'];//图片路径
					//$Ad->save();
				}
			}catch (Exception $e){
				
			}
			
		}
		
		//dump($info);
		//echo $picPath;
		$Ad = D("ad");
				
		if($vo = $Ad->create()) {
			if($picPath!=null){
				$Ad->id=$_POST['id'];
				$Ad->path= $picPath;//图片路径.
			}
			$Ad->userID=Session::get('loginID');
			$Ad->userName=Session::get('loginName');//图片路径.
			$Ad->createDate=date("Y-m-d H:i:s");
			$list=$Ad->save();
			if($list!==false){
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error("没有更新任何数据!");
			}
		}else{
			$this->error($Ad->getError());
		}
		
	}
	
	/**
	 * 检测登录名称是否存在。
	 */
	public function checkLoginName(){
		if(empty($_GET['loginName'])) {
			echo "1";
		}
		
		$isExist = $this->checkLoginNameIsExist($_GET['loginName'],$_GET['id']);
		//dump($isExist);
		if($isExist){
			//echo "1111111111111111111";
			echo 0;//不存在
		} else {
			//echo "2222222";
			echo 1;//存在
		}
	}
	
	private function checkLoginNameIsExist($loginName,$id){
		//echo "33333333";
		if(empty($loginName)){
			return true;
		}
		$Ad	=	M("ad");
		$condition['loginName'] = $loginName;
		$condition['state'] = 1;
		$ret = $Ad->where($condition)->find();
		//echo D('ad')->getLastSql();
		//dump($ret);
		if(!empty($ret) && $ret[id]!==$id){//有对象存在，并且id不一致（编辑的情况下相同）,认为已被使用。
			return false;
		}
		return true;
	}
	
	function updateEdit(){
		if (empty($_GET['id'])){
			$this->error("编辑失败，缺少主键ID");
			return;
		}
		$loginName = Session::get("loginName");
		if($loginName==null){
			$this->error("请先登录");
			return;
		}
		
		$Ad	=	M("ad");
		$vo	=	$Ad->where("state=1")->select($_GET['id']);
		//$vo	=	$Form->getById($_GET['id']);
		//echo $vo[0];
		//dump($vo[0]);
		if($vo && $vo[0]) {
			if($loginName!="admin" && $vo[0]["loginName"]!=$loginName){				
				exit("权限不足,登录名".$loginName.".要修改的用户名=".$vo[0]["loginName"]);
			}
			$this->assign('vo',$vo[0]);
		}else{
			exit('用户不存在！');
		}
		
		
		if($loginName=="admin"){
			$this->display(APP_PATH.'/Tpl/default/Admin/ad/editPwdAdmin.html');
			return;
		}
		
		$this->display(APP_PATH.'/Tpl/default/Admin/ad/editPwd.html');
	}
	
	function updatePWD(){
		if (empty($_POST['id'])){
			$this->error("编辑失败，缺少主键ID");
			return;
		}
		echo 
		$loginName = Session::get("loginName");
		if($loginName==null){
			$this->error("请先登录");
			return;
		}
		$Ad	=	M("ad");
		$vo	=	$Ad->where("state=1")->select($_POST['id']);
		
		dump($vo[0]);
		if($vo && $vo[0]) {
			if($loginName!="admin" && $vo[0]["loginName"]!=$loginName){				
				exit("权限不足,登录名".$loginName.".修改的账号=".$vo[0]["loginName"]);
			}
			$this->assign('vo',$vo[0]);
		}else{
			exit('用户不存在！');
		}
		
		$password = $_POST['password'];
		if(empty($_POST['password']) || strlen($_POST['password']) < 6) {
			$this->error("密码不能为空或小于6位");return;
		}
		if(empty($_POST['password1']) || strlen($_POST['password1']) < 6) {
			$this->error("确认密码不能为空或小于6位");return;
		}
		if($_POST['password'] !== $_POST['password1']){
			$this->error("两次新密码不相同");return;
		}
		
		$Ad=M("ad");
		$vo	= $Ad->where("state=1")->select($_POST['id']);
		if($vo==null || $vo[0]==null) {
			exit('编辑项不存在！');
		}
		
		//e10adc3949ba59abbe56e057f20f883e
		if($loginName!="admin"){
			$oldPassword = MD5($_POST['oldPassword']);
			if($oldPassword!=$vo[0]["password"]){
				exit('原密码错误');
			}
		}

		$Ad=M("ad");

		$Ad->create();
		$Ad->password=MD5($_POST['password']);
		
		$Ad->save();
		
		//$this->display(APP_PATH.'/Tpl/default/Admin/ad/tips.html');
		$this->redirect("tips") ;//重定向;
	}
	
	function tips(){
		$this->display(APP_PATH.'/Tpl/default/Admin/ad/tips.html');
	}
	
	/**
	 * 冻结
	 */
	function freeze(){
		if(!empty($_GET['id'])) {
			$Ad	=	M("ad");
			$Ad->id=$_GET['id'];
			$Ad->state=0;
			$result	= $Ad->save();
			if(false !== $result) {
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	/**
	 * 恢复正常状态
	 */
	function restore() {
		if(!empty($_GET['id'])) {
			$Ad	=	M("ad");
			$Ad->id=$_GET['id'];
			$Ad->state=1;
			$result	= $Ad->save();
			if(false !== $result) {
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
}
?>