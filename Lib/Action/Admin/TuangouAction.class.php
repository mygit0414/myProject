<?php
class TuangouAction extends AdminBaseAction {
	
	function index(){
		$this->userID=Session::get('loginID');
		$condition['state'] = 1;
		$condition['type'] = 9;
		$Product = M("Product");
		
		if($this->userID != 1){//管理员查询所有
			$condition['userID'] = $this->userID;
		}
		$houseList = $Product->where($condition)->page($_GET['p'].',15')->order("id desc")->select();
		//$Product->getLastSql();
		//dump($houseList);
		$this->assign("houseList", $houseList);
		
		import("ORG.Util.Page");// 导入分页类
		$count = $Product->where($condition)->count();// 查询满足要求的总记录数
		$Page = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		
		$district=M("District");
		$distList=$district->where("state=1")->select();
		$this->assign("distList", $distList);
		
		$this->display( APP_PATH.'/Tpl/default/Admin/tuangou/list.html');
	}
	
	function add(){
		$Company = M("Company");
		$com = $Company->find(1);
		$this->assign("com",$com);
		
		$product=M("Product");
		
		$district=M("District");
		$distList=$district->where("state=1")->select();
		//dump($data);
		$this->assign("distList", $distList);
		
		$this->display( APP_PATH.'/Tpl/default/Admin/tuangou/add.html');
	}
	
	function insert(){
		$product=M("Product");
		$product->create();
		//$this->success('数据保存成功！');
		$product->state=1;
		$product->type=9;
		$product->date=date("Y-m-d");
		$product->userID=Session::get('loginID');
		$product->userName=Session::get('loginName');
		//dump($product);return;
		$lastInsId = $product->add();
		
		//dump($product);return;
		//图片
		import('ORG.Net.UploadFile');
		
		$uploadPath = 'Public/Uploads/tuangou/'.date("Ymd").'/';
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  $uploadPath;// 设置附件上传目录
		$upload->saveRule = 'uniqid';//文件名规则
		$upload->uploadReplace = true;
		$upload->thumb = true;
	    $upload->thumbMaxWidth = '400';//多张用,多张用逗号隔开。
	    $upload->thumbMaxHeight = '310';
		if(!$upload->upload()) {// 上传错误提示错误信息
			//$this->error($upload->getErrorMsg());
		}else{// 上传成功 获取上传文件信息
			$fileNameAll = $_REQUEST['fileName'];
			$fileName = array();
			$tempIndex = 0;

			$info =  $upload->getUploadFileInfo();
			//echo count($info);
			$fileNum = $_FILES['file']['size'];//上传文件个数
			for($j=0; $j<count($fileNum); $j++){
				if($fileNum[$j]>0){
					$fileName[$tempIndex]=$fileNameAll[$j];
					$tempIndex++;
				}
			}
			//echo "上传文件个数：".count($fileNum);
			//echo "count:".count($info);
			//echo "dump".dump($info);
			//return;
			for($i=0; $i<count($info); $i++){  
        		//echo $info[$i]['savename'];
        		$picture = M("Picture");
        		$picture->productID=$lastInsId;
				$picture->bigPicUrl="/".$uploadPath.$info[$i]['savename'];
				$picture->thumb="/".$uploadPath.'thumb_'.$info[$i]['savename'];
				$picture->uploadDate=date("Y-m-d H:i:s");;
				$picture->title=$fileName[$i];//指定的文件名称。
				$picture->state=1;
				$picture->userID=Session::get('loginID');
				$picture->userName=Session::get('loginName');;//图片路径.
				$picture->type=1;//产品类型图片
				$picture->add();        		
            }
	   }
		
		$this->redirect("index") ;//重定向到列表方法。
	}
	
	function edit(){
		
		if(!empty($_GET['id'])) {
			$Product=M("Product");
			//$vo	=	$Product->where("state=1")->select($_GET['id']);
			$condition["state"] = 1;
			$condition["id"] = $_GET['id'];
			$vo = $Product->where($condition)->find();
			//$vo	=	$Form->getById($_GET['id']);
			//echo $vo[0];
			//dump($vo);
			if($vo) {
				$vo["applyEndTime"] = strtotime($vo["applyEndTime"]);
				$this->assign('vo',$vo);
				//$this->display(APP_PATH.'/Tpl/default/Admin/agent/edit.html');
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
		
		$product=M("Product");
		
		$district=M("District");
		$distList=$district->where("state=1")->select();
		//dump($data);
		$this->assign("distList", $distList);
		
		$Company = M("Company");
		$com = $Company->find(1);
		$this->assign("com",$com);
		
		//图片
		$Picture = M("Picture");
		$picList = $Picture->where("productID=".$_GET['id']." and state=1 and type=1")->select();
		$this->assign("picList",$picList);		
		 
		Load('extend');//加载扩展函数库
		
		$this->display( APP_PATH.'/Tpl/default/Admin/tuangou/edit.html');
	}
	
	function update(){
		import('ORG.Net.UploadFile');
		if (empty($_POST['id'])){
			$this->error("编辑失败，缺少主键ID");
			return;
		}
		
		$this->udAuth();
		
		$picPath = null;
		$info = null;
		$uploadPath = 'Public/Uploads/tuangou/'.date("Ymd").'/';
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  $uploadPath;// 设置附件上传目录,/不能在上面的pubilc设置，否则保存到数据后显示不出来
		$upload->saveRule = 'uniqid';//文件名规则
		$upload->uploadReplace = true;
		$upload->thumb = true;
	    $upload->thumbMaxWidth = '400';//多张用,多张用逗号隔开。
	    $upload->thumbMaxHeight = '310';
		if(!$upload->upload()) {// 上传错误提示错误信息
			//如果增加了文件上传框却没有选择上传文件，也会出错，因此，这里出错不进行处理。
			//echo "上传错误";
			//$this->error($upload->getErrorMsg());
			//return;
		    //上传失败不要直接返回，有可能是没有选择上传文件。
		}else{// 上传成功 获取上传文件信息
			$fileNameAll = $_REQUEST['fileName'];
			$fileName = array();
			$tempIndex = 0;
			$info =  $upload->getUploadFileInfo();
			//echo count($info);
			$fileNum = $_FILES['file']['size'];//上传文件个数
			for($j=0; $j<count($fileNum); $j++){
				if($fileNum[$j]>0){
					$fileName[$tempIndex]=$fileNameAll[$j];
					$tempIndex++;
				}
			}

			for($i=0; $i<count($info); $i++){  
				//echo $i;
        		//echo $info[$i]['savename'];
        		$picture = M("Picture");
        		$picture->productID=$_POST['id'];
				$picture->bigPicUrl="/".$uploadPath.$info[$i]['savename'];
				$picture->thumb="/".$uploadPath.'thumb_'.$info[$i]['savename'];
				$picture->uploadDate=date("Y-m-d H:i:s");;
				$picture->title=$fileName[$i];//指定的文件名称。
				$picture->state=1;
				$picture->userID=Session::get('loginID');
				$picture->userName=Session::get('loginName');;//图片路径.
				$picture->type=1;//产品类型图片
				$picture->add();        		
            }
	   }


		//删除图片
		$delPicID=$_POST['delPicID'];
		if(!empty($delPicID)){
			$picID = explode(",",$delPicID);
			for($i=0; $i<count($picID); $i++){
				$Picture = M("Picture");
				$Picture->id=$picID[$i];
				$Picture->state=-1;
				$result	= $Picture->save();
			}
		}

		$Product = D("Product");
		if($vo = $Product->create()) {
			$list=$Product->save();
			if($list!==false){
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error("没有更新任何数据!");
			}
		}else{
			$this->error($Product->getError());
		}

		$this->redirect("index") ;//重定向到列表方法。
	}
	
	//删除房源
	public function delete() {
		if(!empty($_GET['id'])) {
			$this->udAuth();
			
			$House	=	M("Product");
			$House->id=$_GET['id'];
			$House->state=-1;
			$result	= $House->save();
			if(false !== $result) {
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	function editTuanGouDesc(){
		$Company = M("Company");
		$com = $Company->find(1);
		$this->assign("com",$com);
			
		$this->display( APP_PATH.'/Tpl/default/Admin/tuangou/tuangouDesc.html');
	}
	
	function updateTuanGouDesc(){
				
		if (empty($_POST['id'])){
			$this->error("编辑失败，缺少主键ID");
			return;
		}
		
		$Company = D("Company");
		
		if($vo = $Company->create()) {
			
			$list=$Company->save();
			if($list!==false){
				$this->redirect("editTuanGouDesc") ;//重定向到列表方法。
			}else{
				$this->error("没有更新任何数据!");
			}
		}else{
			$this->error($Company->getError());
		}
		
	}
}

?>
