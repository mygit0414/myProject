<?php

class HouseAction extends AdminBaseAction {
	
	public function index(){
		//echo time();
		//echo "--";
		//echo date("Y-m-d");
		$this->userID=Session::get('loginID');
		//echo $this->userID;
		//return;
		$houseTypeArr = houseTypeArray();
		//dump($aa);
		$this->assign("houseTypeArr",$houseTypeArr);
		
		$priceArr = priceArray();
		$this->assign("priceArr",$priceArr);
		
		$areaArr = areaArray();
		$this->assign("areaArr",$areaArr);
		
		$district=M("District");
		$distList=$district->where("state=1")->select();
		$this->assign("distList", $distList);
		
		if(!empty($_GET['useArea'])){
			//echo "noEmpty";
			if($_GET['useArea'] == 1){
				//echo "1";
				$condition['useArea'] = array('lt',40);
			}
			if($_GET['useArea'] == 2){
				//echo "2";
				$condition['useArea'] = array(array('egt',40),array('elt',60));
			}
			if($_GET['useArea'] == 3){
				//echo "3";
				$condition['useArea'] = array(array('egt',60),array('elt',80));
			}
			if($_GET['useArea'] == 4){
				//echo "4";
				$condition['useArea'] = array(array('egt',80),array('elt',100));
			}
			if($_GET['useArea'] == 5){
				//echo "5";
				$condition['useArea'] = array(array('egt',100),array('elt',120));
			}
			if($_GET['useArea'] == 6){
				//echo "6";
				$condition['useArea'] = array(array('egt',120),array('elt',144));
			}
			if($_GET['useArea'] == 7){
				$condition['useArea'] = array('gt',144);
			}
		}
	
		if($this->userID != 1){//管理员查询所有
			$condition['userID'] = $this->userID;
		}
		$condition['state'] = 1;
		if(!empty($_GET['productName'])){
	    	$condition['productName'] = array('like',"%".urldecode($_GET['productName'])."%");
		}
	    if($_GET['type'] != 0){
	    	$condition['type'] = $_GET['type'];
	    } else {
	    	$condition['type'] = array(array('eq',1),array('eq',2), 'or') ;
	    }
	    if($_GET['districtID'] != 0){
	    	$condition['districtID'] = $_GET['districtID'];
	    }
	    if($_GET['totalPrice'] != 0){
	    	$condition['totalPrice'] = $_GET['totalPrice'];
	    }
	    if($_GET['houseType'] != 0){
	    	$condition['houseType'] = $_GET['houseType'];
	    }
	    
	    //记住查询参数
	    $this->assign("useArea", $_GET['useArea']);
	    $this->assign("productName", urldecode($_GET['productName']));
	    $this->assign("totalPrice", $_GET['totalPrice']);
	    $this->assign("houseType", $_GET['houseType']);//一房一厅，二房一厅等
	    $this->assign("type", $_GET['type']);//新房或二手房
	    $this->assign("districtID", $_GET['districtID']);



		$Product = M("Product");
		$houseList = $Product->where($condition)->page($_GET['p'].',15')->order("sort desc,id desc")->select();
		//$Product->getLastSql();
		//dump($houseList);
		$this->assign("houseList", $houseList);


		import("ORG.Util.Page");// 导入分页类
		$count = $Product->where($condition)->count();// 查询满足要求的总记录数
		$Page = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出

		$this->display( APP_PATH.'/Tpl/default/Admin/house/list.html');
	}
	
	public function add(){
		
		$district=M("District");
		$distList=$district->where("state=1")->select();
		//dump($data);
		$this->assign("distList", $distList);//区域
		
		$houseTypeArr = houseTypeArray();
		//dump($aa);
		$this->assign("houseTypeArr",$houseTypeArr);//房型,如:3室2厅
		
		$propertyTypeArr = propertyTypeArray();
		$this->assign("propertyTypeArr",$propertyTypeArr);//物业类型，如：新房，二手房，出租
		
		$directionArr = directionArray();
		$this->assign("directionArr",$directionArr);//朝向
		
		$decorationArr = decorationArray();
		$this->assign("decorationArr",$decorationArr);//装修
		
		$Company = M("Company");
		$com	=	$Company->find(1);
		
		//dump($comVO);return;
		$this->assign("com",$com);
		
		$this->display( APP_PATH.'/Tpl/default/Admin/house/add.html');
	}
	
	/**
	 * 增加新房
	 */
	function insert(){
		$product=M("Product");
		$product->create();
		//$this->success('数据保存成功！');
		$product->state=1;
		$product->date=date("Y-m-d");
		$product->userID=Session::get('loginID');
		$product->userName=Session::get('loginName');
		$lastInsId = $product->add();
		
		//图片
		import('ORG.Net.UploadFile');
		
		$uploadPath = 'Public/Uploads/house/'.date("Ymd").'/';
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
					$fileName[$tempIndex]=$fileNameAll[$j];//指定图片名称
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
		
		$houseTypeArr = houseTypeArray();
		//dump($aa);
		$this->assign("houseTypeArr",$houseTypeArr);
		
		$propertyTypeArr = propertyTypeArray();
		$this->assign("propertyTypeArr",$propertyTypeArr);
		
		$directionArr = directionArray();
		$this->assign("directionArr",$directionArr);
		
		$decorationArr = decorationArray();
		$this->assign("decorationArr",$decorationArr);
		
		$Company = M("Company");
		$com = $Company->find(1);
		$this->assign("com",$com);
		
		//图片
		$Picture = M("Picture");
		$picList = $Picture->where("productID=".$_GET['id']." and state=1 and type=1")->select();
		$this->assign("picList",$picList);
		
		Load('extend');//加载扩展函数库
		$this->display( APP_PATH.'/Tpl/default/Admin/house/edit.html');
	}
	
	function temp(){
		$this->display( APP_PATH.'/Tpl/default/Admin/house/file.html');
	}
	
	/**
	 * test
	function file(){
		import('ORG.Net.UploadFile');
		
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  './Public/Uploads/house/'.date("Ymd").'/';// 设置附件上传目录
		$upload->saveRule = uniqid;//文件名规则
		$upload->uploadReplace = true;
		$upload->thumb = true;
	    $upload->thumbMaxWidth = '144';//多张用,多张用逗号隔开。
	    $upload->thumbMaxHeight = '130';
		if(!$upload->upload()) {// 上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		}else{// 上传成功 获取上传文件信息
			
			$fileName = $_REQUEST['fileName'];
			$info =  $upload->getUploadFileInfo();
			//echo count($info);
			for($i=0; $i<count($info); $i++){  
        		echo $info[$i]['savename'];
        		$picture = M("Picture");
        		
				$picture->bigPicUrl=$upload->savePath.$info[$i]['savename'];
				$picture->thumb=$upload->savePath.'thumb_'.$info[$i]['savename'];
				$picture->uploadDate=date("Y-m-d H:i:s");;
				$picture->title=$fileName[$i];
				$picture->state=1;
				$picture->userID=Session::get('loginID');
				$picture->userName=Session::get('loginName');;//图片路径.
				$picture->add();
            }
	   }
	}
	*/
	
	
	function update(){
		import('ORG.Net.UploadFile');
		if (empty($_POST['id'])){
			$this->error("编辑失败，缺少主键ID");
			return;
		}
		$this->udAuth();

		$picPath = null;
		$info = null;
		$uploadPath = 'Public/Uploads/house/'.date("Ymd").'/';
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
			//如果增加了文件上传框却没有选择上传文件，也会出错，因此，这里出错不进行处理。
			//echo "上传错误";
			//$this->error($upload->getErrorMsg());
		}else{// 上传成功 获取上传文件信息
			//取得成功上传的文件信息
		    $uploadList = $upload->getUploadFileInfo();
//		    import("@.ORG.Image");
		    //给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
//		    Image::water($uploadList[0]['savepath'] . 'm_' . $uploadList[0]['savename'], APP_PATH.'Tpl/Public/Images/logo.png');
		    
			$fileNameAll = $_REQUEST['fileName'];
			$fileName = array();
			$tempIndex = 0;

			$info =  $upload->getUploadFileInfo();
		//	echo count($info);
			$fileNum = $_FILES['file']['size'];//上传文件个数
			for($j=0; $j<count($fileNum); $j++){
				if($fileNum[$j]>0){
					$fileName[$tempIndex]= $fileNameAll[$j];//指定图片名称
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
		
		//echo "删除完图片";
		//return;
		//dump($info);
		//echo $picPath;
		$Product = D("Product");
		//$sex = $_POST['sex'];
		//dump($Agent);
		
		if($vo = $Product->create()) {
			//echo dump($Product);
			
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
	
	/**
	 * 设置产品推荐图
	 */
	public function recommendationPic(){
		//echo "id=".$_GET['id'];
		//echo "flag=".$_GET['flag'];
		if(!empty($_GET['id'])) {
			$this->udAuth();
			$Picture = M("Picture");
			$Picture->id=$_GET['id'];
			$Picture->recommendation=$_GET['flag']!=1?null:$_GET['flag'];//1表示推荐，空或其它不推荐
			$result	= $Picture->save();
			if(false !== $result) {
				echo "success";
			}else{
				echo "-1";
			}
		} else {
			echo "-1";
		}
		
	}
	
/**
	 * 设置产品推荐图
	 */
	public function sortUp(){
		//echo "id=".$_GET['id'];
		//echo "flag=".$_GET['flag'];
		if(!empty($_GET['id'])) {
			$this->udAuth();
			
			$Product = M("Product");
			$Product->id=$_GET['id'];
			$Product->sort=$_GET['sortVal'];//排序值
			$result	= $Product->save();
			if(false !== $result) {
				echo "success";
			}else{
				echo "-1";
			}
		} else {
			echo "-1";
		}
		
	}
}
?>