<?php
class ShangpuAction extends AdminBaseAction {
	
	function index(){
		$this->userID=Session::get('loginID');
		$areaArr = areaArray();
		$this->assign("areaArr",$areaArr);
		
		$priceArr = priceArray();
		$this->assign("priceArr",$priceArr);
		
		$houseTypeArr = houseTypeArray();
		$this->assign("houseTypeArr",$houseTypeArr);
		
		$district=M("District");
		$distList=$district->where("state=1")->select();
		$this->assign("distList", $distList);
		
		if(!empty($_GET['useArea'])){
			//echo "noEmpty";
			if($_GET['useArea'] == 1){
				//echo "1";
				$condition['area'] = array('lt',40);
			}
			if($_GET['useArea'] == 2){
				//echo "2";
				$condition['area'] = array(array('egt',40),array('elt',60));
			}
			if($_GET['useArea'] == 3){
				//echo "3";
				$condition['area'] = array(array('egt',60),array('elt',80));
			}
			if($_GET['useArea'] == 4){
				//echo "4";
				$condition['area'] = array(array('egt',80),array('elt',100));
			}
			if($_GET['useArea'] == 5){
				//echo "5";
				$condition['useArea'] = array(array('egt',100),array('elt',120));
			}
			if($_GET['useArea'] == 6){
				//echo "6";
				$condition['area'] = array(array('egt',120),array('elt',144));
			}
			if($_GET['useArea'] == 7){
				$condition['area'] = array('gt',144);
			}
		}
		
		if($this->userID != 1){//管理员查询所有
			$condition['userID'] = $this->userID;
		}
		
		//区域
		if(!empty($_GET['saleType']) && $_GET['saleType']!=0){
	    	$condition['saleType'] = $_GET['saleType'];
	    }
	    
		//区域
		if($_GET['districtID'] != 0){
	    	$condition['districtID'] = $_GET['districtID'];
	    }
	    
	    //户型
		if($_GET['houseType'] != 0){
	    	$condition['houseType'] = $_GET['houseType'];
	    }
	    
	    if(!empty($_GET['productName'])) {
	    	$condition['productName'] = array('like',"%".urldecode($_GET['productName'])."%");
	    }
	    
	    //记住查询参数
	    $this->assign("useArea", $_GET['useArea']);
	    $this->assign("productName", urldecode($_GET['productName']));
	   	$this->assign("totalPrice", $_GET['totalPrice']);
	    $this->assign("districtID", $_GET['districtID']);
	    $this->assign("saleType", $_GET['saleType']);
	    
	    $condition['state'] = 1;
	    $condition['type'] = 3;
		$product=M("Product");
		$productList=$product->where($condition)->page($_GET['p'].',15')->order("sort desc,id desc")->select();
		//dump($data);
		$this->assign("productList", $productList);
		
		$district=M("District");
		$distList=$district->where("state=1")->select();
		$this->assign("distList", $distList);
		
		$saleTypeArr = saleTypeArray();
		$this->assign("saleTypeArr", $saleTypeArr);
		
		$this->display( APP_PATH.'/Tpl/default/Admin/shangpu/list.html');
	}
	
	function add(){
		
		$district=M("District");
		$distList=$district->where("state=1")->select();
		$this->assign("distList", $distList);
		
		$decorationArr = decorationArray();//装修
		$this->assign("decorationArr",$decorationArr);
		
		$this->display( APP_PATH.'/Tpl/default/Admin/shangpu/add.html');
	}
	
	function insert(){
		$product=M("Product");
		$product->create();
		//$this->success('数据保存成功！');
		$product->state=1;
		$product->type=3;
		$product->date=date("Y-m-d");
		$product->userID=Session::get('loginID');
		$product->userName=Session::get('loginName');
		//dump($product);return;
		$lastInsId = $product->add();
		
		//dump($product);return;
		//图片
		import('ORG.Net.UploadFile');
		
		$uploadPath = 'Public/Uploads/shangpu/'.date("Ymd").'/';
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  $uploadPath;// 设置附件上传目录
		$upload->saveRule = 'uniqid';//文件名规则
		$upload->uploadReplace = true;
		$upload->thumb = true;
	    $upload->thumbMaxWidth = '144';//多张用,多张用逗号隔开。
	    $upload->thumbMaxHeight = '130';
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
			$vo	=	$Product->where("state=1")->select($_GET['id']);
			//$vo	=	$Form->getById($_GET['id']);
			//echo $vo[0];
			//dump($vo);
			if($vo && $vo[0]) {
				$this->assign('vo',$vo[0]);
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
		
		
		
		$decorationArr = decorationArray();//装修
		$this->assign("decorationArr",$decorationArr);
		
		
		
		$Company = M("Company");
		$com = $Company->find(1);
		$this->assign("com",$com);
		
		//图片
		$Picture = M("Picture");
		$picList = $Picture->where("productID=".$_GET['id']." and state=1 and type=1")->select();
		$this->assign("picList",$picList);
		
		Load('extend');//加载扩展函数库
		$this->display( APP_PATH.'/Tpl/default/Admin/shangpu/edit.html');
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
		$uploadPath = 'Public/Uploads/shangpu/'.date("Ymd").'/';
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  $uploadPath;// 设置附件上传目录,/不能在上面的pubilc设置，否则保存到数据后显示不出来
		$upload->saveRule = 'uniqid';//文件名规则
		$upload->uploadReplace = true;
		$upload->thumb = true;
	    $upload->thumbMaxWidth = '144';//多张用,多张用逗号隔开。
	    $upload->thumbMaxHeight = '130';
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
				echo $i;
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
	
	//删除商铺
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
}

?>