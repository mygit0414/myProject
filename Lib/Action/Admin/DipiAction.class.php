<?php
/**地皮，仓库，厂房管理类**/

class DipiAction extends AdminBaseAction {
	
	function index(){
		
		$this->userID=Session::get('loginID');
		
		//面积区间
		$areaArr = areaArray();
		$this->assign("areaArr",$areaArr);
		
		//价格区间
		$priceArr = priceArray();
		$this->assign("priceArr", $priceArr);
		
		//地产类型
		$propertyTypeArr = propertyTypeArray();
		$this->assign("propertyTypeArr", $propertyTypeArr);
		
		//销售类型
		$saleTypeArray = saleTypeArray();
		$this->assign("saleTypeArray", $saleTypeArray);
		
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
		
		if(!empty($_GET['productName'])) {
	    	$condition['productName'] = array('like',"%".urldecode($_GET['productName'])."%");
	    }
	    
	    //记住查询参数
	    $this->assign("useArea", $_GET['useArea']);
	    $this->assign("productName", urldecode($_GET['productName']));
	   // $this->assign("totalPrice", $_GET['totalPrice']);
	    $this->assign("houseType", $_GET['houseType']);//一房一厅，二房一厅等
	   // $this->assign("type", $_GET['type']);//新房或二手房
	    $this->assign("districtID", $_GET['districtID']);
	    
		$condition['state'] = 1;
		if(empty($_GET['type'])){
			$condition['type'] = array(array('eq',6),array('eq',7),array('eq',8),array('eq',10), 'or') ;
		} else {
			$condition['type'] = $_GET['type'];
		}
		/**
		if($_GET['type']==7){
			$condition['type'] = 7;
		}
		if($_GET['type']==8){
			$condition['type'] = 8;
		}
		if($_GET['type']==10){
			$condition['type'] = 10;
		}
		*/
		$Product = M("Product");
		$houseList = $Product->where($condition)->page($_GET['p'].',15')->order("id desc")->select();
		//$Product->getLastSql();
		//dump($houseList);
		$this->assign("houseList", $houseList);
		
		import("ORG.Util.Page");// 导入分页类
		$count = $Product->where($condition)->count();// 查询满足要求的总记录数
		$Page = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		
		$this->display(APP_PATH.'/Tpl/default/Admin/dipi/list.html');
	}
	
	function add(){
		
		$landTypeArr = landTypeArray();//土地类型
		$this->assign("landTypeArr",$landTypeArr);
		
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
		
		$depositTypeArr = depositTypeArray();//押金类型
		$this->assign("depositTypeArr",$depositTypeArr);
		
		$Company = M("Company");
		$com	=	$Company->find(1);
		//dump($comVO);return;
		$this->assign("com",$com);
		$this->display(APP_PATH.'/Tpl/default/Admin/dipi/add.html');
	}
	
	function insert(){
		$product=M("Product");
		$product->create();
		//$this->success('数据保存成功！');
		$product->state=1;
		$product->type=5;
		$product->date=date("Y-m-d");
		$product->userID=Session::get('loginID');
		$product->userName=Session::get('loginName');
		//dump($product);return;
		$lastInsId = $product->add();
		
		//dump($product);return;
		//图片
		import('ORG.Net.UploadFile');
		
		$uploadPath = 'Public/Uploads/dichan/'.date("Ymd").'/';
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
		
		$landTypeArr = landTypeArray();//土地类型
		$this->assign("landTypeArr",$landTypeArr);
		
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
		
		$decorationArr = decorationArray();//装修
		$this->assign("decorationArr",$decorationArr);
		
		$depositTypeArr = depositTypeArray();//押金类型
		$this->assign("depositTypeArr",$depositTypeArr);
		
		$Company = M("Company");
		$com = $Company->find(1);
		$this->assign("com",$com);
		
		//图片
		$Picture = M("Picture");
		$picList = $Picture->where("productID=".$_GET['id']." and state=1 and type=1")->select();
		$this->assign("picList",$picList);
		
		Load('extend');//加载扩展函数库
		$this->display( APP_PATH.'/Tpl/default/Admin/dipi/edit.html');
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
		$uploadPath = 'Public/Uploads/dichan/'.date("Ymd");
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
			//dump($vo);
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
	
	//	删除
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