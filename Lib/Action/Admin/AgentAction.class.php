<?php
/**
 * 经纪人管理（同时也作为网站管理员）
 *
 */
class AgentAction extends AdminBaseAction {
	
	/**
	 * 显示已存在的经纪人
	 */
	public function index(){
		$agent=M("Agent");
		$agentList=$agent->where("state=1 or state=0")->order('id desc')->select();
		//dump($data);
		$this->assign("agentList", $agentList);
		$this->display( APP_PATH.'/Tpl/default/Admin/agent/list.html');
	}
	
	/**
	 * 跳转到新增自定义的页面
	 */
	public function add(){
		$this->display(APP_PATH.'/Tpl/default/Admin/agent/add.html');
	}
	
	function insert(){
		import('ORG.Net.UploadFile');
		//先增加记录
		$agent=M("Agent");
		$agent->create();
		//$agent->headPic = $info[0]['savename']; // 保存上传的照片根据需要自行组装
		$sex = $_POST['sex'];
		if($sex!=null){
				$agent->sex=$sex;
		}
		
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirmPassword'];
		if(empty($_POST['password']) || strlen($_POST['password']) < 6) {
			$this->error("密码不能为空或小于6位");
		}
		if(empty($_POST['confirmPassword']) || strlen($_POST['confirmPassword']) < 6) {
			$this->error("确认密码不能为空或小于6位");
		}
		if($_POST['confirmPassword'] !== $_POST['password']){
			$this->error("确认密码不能为空或小于6位");
		}
		
		$agent->password=MD5($_POST['password']);
		//dump($agent);
		//return;
		$id = $agent->add();
		if(!$id){
			$this->error("写入数据失败");
		}
			
		if(is_uploaded_file($_FILES['headPic']['tmp_name'])) {//如果选择上传文件
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  'Public/Uploads/agent/'.$id.'/';// 设置附件上传目录
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
					$agent->headPic='/Public/Uploads/agent/'.$id.'/'.$info[0]['savename'];//图片路径.
				}
			}catch(Exception $e){
				echo $e;
			}
		}
		
		$agent->id=$id;
		$agent->save();
		
		$this->redirect("index") ;//重定向到列表方法。
		
	}
	
	// 删除数据
	public function delete() {
		if(!empty($_GET['id'])) {
			$Agent	=	M("Agent");
			$Agent->id=$_GET['id'];
			$Agent->state=-1;
			$result	=	$Agent->save();
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
			$Agent	=	M("Agent");
			$vo	=	$Agent->where("state=1")->select($_GET['id']);
			//$vo	=	$Form->getById($_GET['id']);
			//echo $vo[0];
			//dump($vo);
			if($vo && $vo[0]) {
				$this->assign('vo',$vo[0]);
				$this->display(APP_PATH.'/Tpl/default/Admin/agent/edit.html');
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
		if(is_uploaded_file($_FILES['headPic']['tmp_name'])) {//如果选择上传文件
			
			try {
				$upload = new UploadFile();// 实例化上传类
				$upload->maxSize  = 3145728 ;// 设置附件上传大小
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				$upload->savePath =  'Public/Uploads/agent/'.$_POST['id'].'/';// 设置附件上传目录
				$upload->uploadReplace = true;
				$upload->saveRule = 'uniqid';//文件名规则
		//		$upload->thumb = true;
		//	    $upload->thumbMaxWidth = '50,200';
		//	    $upload->thumbMaxHeight = '50,200';
				if(!$upload->upload()) {// 没有选择上传图片
					
				}else{// 上传成功 获取上传文件信息
					$info =  $upload->getUploadFileInfo();
					//echo "dump".dump($info);
					$picPath = '/Public/Uploads/agent/'.$_POST['id'].'/'.$info[0]['savename'];//图片路径
					//$agent->save();
				}
			}catch (Exception $e){
				
			}
			
		}
		
		//dump($info);
		//echo $picPath;
		$Agent = D("Agent");
		$sex = $_POST['sex'];
		//dump($Agent);
		
		if($vo = $Agent->create()) {
			if($picPath!=null){
				$Agent->id=$_POST['id'];
				$Agent->headPic= $picPath;//图片路径.
			}
			if($sex!=null){
				$Agent->sex=$sex;
			}
			$list=$Agent->save();
			if($list!==false){
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error("没有更新任何数据!");
			}
		}else{
			$this->error($Agent->getError());
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
			echo "1111111111111111111";
			echo 0;//不存在
		} else {
			echo "2222222";
			echo 1;//存在
		}
	}
	
	private function checkLoginNameIsExist($loginName,$id){
		//echo "33333333";
		if(empty($loginName)){
			return true;
		}
		$Agent	=	M("Agent");
		$condition['loginName'] = $loginName;
		$condition['state'] = 1;
		$ret = $Agent->where($condition)->find();
		//echo D('Agent')->getLastSql();
		//dump($ret);
		if(!empty($ret) && $ret[id]!=$id){//有对象存在，并且id不一致（编辑的情况下相同）,认为已被使用。
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
		
		$Agent	=	M("Agent");
		$vo	=	$Agent->where("state=1")->select($_GET['id']);
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
			$this->display(APP_PATH.'/Tpl/default/Admin/agent/editPwdAdmin.html');
			return;
		}
		
		$this->display(APP_PATH.'/Tpl/default/Admin/agent/editPwd.html');
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
		$Agent	=	M("Agent");
		$vo	=	$Agent->where("state=1")->select($_POST['id']);
		
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
		
		$agent=M("Agent");
		$vo	= $agent->where("state=1")->select($_POST['id']);
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

		$Agent=M("Agent");

		$Agent->create();
		$Agent->password=MD5($_POST['password']);
		
		$Agent->save();
		
		//$this->display(APP_PATH.'/Tpl/default/Admin/agent/tips.html');
		$this->redirect("tips") ;//重定向;
	}
	
	function tips(){
		$this->display(APP_PATH.'/Tpl/default/Admin/agent/tips.html');
	}
	
	/**
	 * 冻结
	 */
	function freeze(){
		if(!empty($_GET['id'])) {
			$Agent	=	M("Agent");
			$Agent->id=$_GET['id'];
			$Agent->state=0;
			$result	= $Agent->save();
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
			$Agent	=	M("Agent");
			$Agent->id=$_GET['id'];
			$Agent->state=1;
			$result	= $Agent->save();
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