<?php
/**
 * 企业信息管理类
 */
class CompanyAction extends AdminBaseAction{
	
	public function index(){
	
		$Company = M("Company");
		$vo	=	$Company->select();
		//echo D('Company')->getLastSql();
		//$vo	=	$Form->getById($_GET['id']);
		//echo $vo[0];
		//dump($vo);
		//return;
		if($vo && $vo[0]) {
			$this->assign('vo',$vo[0]);
		}else{
			exit('编辑项不存在！');
		}
		
		$this->display(APP_PATH.'/Tpl/default/Admin/company/index.html');
	}
	
	public function update(){
		import('ORG.Net.UploadFile');
		if (empty($_POST['id'])){
			$this->error("编辑失败，缺少主键ID");
			return;
		}
		
		$picPath = null;
		$info = null;
		if(!empty($_FILES)) {
			
			try {
				$upload = new UploadFile();// 实例化上传类
				$upload->maxSize  = 3145728 ;// 设置附件上传大小
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				$upload->savePath =  './Public/Uploads/company/';// 设置附件上传目录
				$upload->uploadReplace = true;
				$upload->saveRule = 'logo'; 
		//		$upload->thumb = true;
		//	    $upload->thumbMaxWidth = '50,200';
		//	    $upload->thumbMaxHeight = '50,200';
				if(!$upload->upload()) {// 没有选择上传图片
					
				}else{// 上传成功 获取上传文件信息
					$info =  $upload->getUploadFileInfo();
					$picPath = '/Public/Uploads/company/'.$info[0]['savename'];//图片路径.;//图片路径.
				}
			}catch (Exception $e){
				
			}
			
		}
		
		//dump($info);
		//echo $picPath;
		$Company = D("Company");
		
		
		if($vo = $Company->create()) {
			if($picPath!=null){
				$Company->id=$_POST['id'];
				$Company->logo= $picPath;//图片路径.
			}
			
			$list=$Company->save();
			if($list!==false){
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error("没有更新任何数据!");
			}
		}else{
			$this->error($Company->getError());
		}
	}
	
	public function proDefaultPicShow(){
		$Company = M("Company");
		$vo	=	$Company->select();
		//echo D('Company')->getLastSql();
		//$vo	=	$Form->getById($_GET['id']);
		//echo $vo[0];
		//dump($vo);
		//return;
		if($vo && $vo[0]) {
			$this->assign('vo',$vo[0]);
		}else{
			exit('编辑项不存在！');
		}
		$this->display(APP_PATH.'/Tpl/default/Admin/proDefaultPic.html');
	}
	
	public function proDefaultPic(){
		import('ORG.Net.UploadFile');
		if (empty($_POST['id'])){
			$this->error("编辑失败，缺少主键ID");
			return;
		}
		
		$picPath = null;
		$info = null;
		if(!empty($_FILES)) {
			
			try {
				$upload = new UploadFile();// 实例化上传类
				$upload->maxSize  = 3145728 ;// 设置附件上传大小
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				$upload->savePath =  './Public/images/';// 设置附件上传目录
				$upload->uploadReplace = true;
				$upload->saveRule = 'default'; 
				$upload->thumb = true;//不生成缩略图
				$upload->thumbRemoveOrigin = true;
				$upload->thumbPrefix = 'pro_';  //生产2张缩略图
				//$upload->thumbSuffix = ''//后缀
			    $upload->thumbMaxWidth = '110';
			    $upload->thumbMaxHeight = '110';
				if(!$upload->upload()) {// 没有选择上传图片
					
				}else{// 上传成功 获取上传文件信息
					$info =  $upload->getUploadFileInfo();
					$picPath = '/Public/images/'.$upload->thumbPrefix.$info[0]['savename'];//图片路径.;//图片路径.
				}
			}catch (Exception $e){
				
			}
			
		}
		
		//dump($info);
		//echo $picPath;
		$Company = D("Company");
		
		
		if($vo = $Company->create()) {
			if($picPath!=null){
				$Company->id=$_POST['id'];
				$Company->proDefaultPic= $picPath;//图片路径.
			}
			
			$list=$Company->save();
			if($list!==false){
				$this->redirect("proDefaultPicShow") ;//重定向到列表方法。
			}else{
				$this->error("没有更新任何数据!");
			}
		}else{
			$this->error($Company->getError());
		}
	}
}
?>