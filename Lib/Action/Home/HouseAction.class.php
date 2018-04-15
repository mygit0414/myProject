<?php
class HouseAction extends HomeBaseAction {
	
	/**
	 * 二手房搜索
	 */
	public function second_handHouse(){
		
	}
	
	/**
	 * 新房搜索
	 */
	public function search() {
		$price = $_GET['price'];
		$houseType = $_GET['houseType'];//一房一厅，二房一厅等。
		$area = $_GET['useArea'];
		$keyWord = $_GET['keyWord'];
		$type = $_GET['type'];//产品类型：新房，二手房。
		$districtID = $_GET["dist"];//区域
		
		if(!empty($_GET['price'])){
			//echo "noEmpty";
			if($_GET['price'] == 1){
				//echo "1";
				$condition['product.totalPrice'] = array('lt',20);
			}
			if($_GET['price'] == 2){
				//echo "2";
				$condition['product.totalPrice'] = array(array('egt',20),array('elt',40));
			}
			if($_GET['price'] == 3){
				//echo "3";
				$condition['product.totalPrice'] = array(array('egt',40),array('elt',60));
			}
			if($_GET['price'] == 4){
				//echo "4";
				$condition['product.totalPrice'] = array(array('egt',60),array('elt',80));
			}
			if($_GET['price'] == 5){
				//echo "4";
				$condition['product.totalPrice'] = array(array('egt',80),array('elt',100));
			}
			if($_GET['price'] == 6){
				//echo "5";
				$condition['product.totalPrice'] = array(array('egt',100),array('elt',150));
			}
			if($_GET['price'] == 7){
				//echo "6";
				$condition['product.totalPrice'] = array(array('egt',150),array('elt',200));
			}
			if($_GET['price'] == 8){
				$condition['product.totalPrice'] = array('gt',200);
			}
		}
		
		//面积
		if(!empty($area)){
			//echo "noEmpty";
			if($area == 1){
				//echo "1";
				$condition['product.area'] = array('lt',40);
			}
			if($area == 2){
				//echo "2";
				$condition['product.area'] = array(array('egt',40),array('elt',60));
			}
			if($area == 3){
				//echo "3";
				$condition['product.area'] = array(array('egt',60),array('elt',80));
			}
			if($area == 4){
				//echo "4";
				$condition['product.area'] = array(array('egt',80),array('elt',100));
			}
			if($area == 5){
				//echo "4";
				$condition['product.area'] = array(array('egt',100),array('elt',120));
			}
			if($area == 6){
				//echo "5";
				$condition['product.area'] = array(array('egt',120),array('elt',144));
			}
			if($area == 7){
				$condition['product.area'] = array('gt',144);
			}
		}
		if(!empty($districtID)){
			$condition['product.districtID'] = $districtID;
		}
		
		$condition['product.state'] = 1;
		if(!empty($keyWord)){
	    	$condition['product.productName'] = array('like',"%".urldecode($keyWord)."%");
		}
		if(!empty($type)){
			$condition['product.type'] = $type;
		}
		
	    //记住查询参数
	    $this->assign("useArea", $_GET['useArea']);
	    $this->assign("keyWord", urldecode($_GET['keyWord']));
	    $this->assign("totalPrice", $_GET['price']);
	    $this->assign("houseType", $_GET['houseType']);//一房一厅，二房一厅等
	    $this->assign("type", $_GET['type']);//新房或二手房
	    $this->assign("districtID", $districtID);
	    
	    
		
		$Product = M("Product");
//		$houseList = $Product->where($condition)->page($_GET['p'].',15')->select();
		$houseList = $Product->
			field("product.*,agent.sex,agent.mobile,agent.qq,agent.introduction,agent.headPic,agent.nickName" )-> 
			join('left JOIN agent ON product.userID = agent.id')->
			where($condition)->order('product.id desc' )->page($_GET['p'].',15')->select();
//		//获取图片
		for($i=0; $i<=count($houseList)-1; $i++){
			$condition1['productID'] = $houseList[$i]["id"];
			$condition1['state'] = 1;
			$condition1['type'] = 1;//产品类型图片
			$Picture = M("Picture");
			$pictureList = $Picture->where($condition1)->order('recommendation desc')->limit(1)->select();
			//echo "aa=".count($pictureList);
			//dump($pictureList);
			if($pictureList!=null && count($pictureList)>0){
				$houseList[$i]["picture"] = $pictureList[0]["thumb"];
			} 
		}
		//$Product->getLastSql();
		//dump($houseList);
		$this->assign("houseList", $houseList);
		import("ORG.Util.Page");// 导入分页类
		$count = $Product->where($condition)->count('id');// 查询满足要求的总记录数
		$Page = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		
		$propertyTypeArr = propertyTypeArray();
		$this->assign("propertyTypeArr",$propertyTypeArr);//物业类型，如：新房，二手房，出租

		
		$priceArr = priceArray();
		$view_price = getKey($priceArr,$_GET['price']);
		$this->assign("view_price",$view_price);//默认显示的价格文字
		$this->assign("priceArr",$priceArr);//价格区间
		
		$houseTypeArr = houseTypeArray();
		$this->assign("houseTypeArr",$houseTypeArr);
		$view_houseType = getKey($houseTypeArr,$_GET['houseType']);
		$this->assign("view_houseType",$view_houseType);//默认显示的房型文字
		
		
		$areaArr = areaArray();
		$this->assign("areaArr",$areaArr);
		$view_area = getKey($areaArr,$_GET['useArea']);
//		echo $_GET['useArea']."===".$view_area;return;
		$this->assign("view_area",$view_area);//默认显示的面积文字
		
		//区域类型
		$district=M("District");
		$distList=$district->where("state=1")->select();
		$this->assign("distList", $distList);
	
		foreach($distList as $key =>$val) {
			if($val["id"] == $districtID){
				$view_distName = $val["name"];
			}
		}
		$this->assign("view_distName", $view_distName);		

		Load('extend');//加载扩展函数库 字符串截取
		
		$this->assign("type",$type);
		if($type==2){
			$this->display(APP_PATH.'/Tpl/default/Home/second-handHouse.html');	
		} else {
			$this->display(APP_PATH.'/Tpl/default/Home/newHouseList.html');	
		}
	    
	}
	
	public function view(){
		$id = $_GET['id'];
		if(empty($id)) {
			//$this->error("房源不存在！");	
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: /");
		}
		if(!empty($_GET['type'])){
			//有type参数的话去掉
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: /house/view?id=".$id);
		}
		
		$ProductDao = M("Product");
		$condition['id'] = $id;
		$condition['state'] = 1;
		$product = $ProductDao->where($condition)->find();
		if(empty($product)){
			//$this->error("房源不存在！");	
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: /");
		}
		$this->assign("product",$product);
		
		//seo跳转
		if($product['type']==3){
			//有type参数的话去掉
			header("HTTP/1.1 301 Moved Permanently"); 
			header("Location: /shangpu/".$id.".html");
		}
	//	dump($product);return;
		
		$propertyTypeArr = propertyTypeArray();
		$this->assign("propertyTypeArr",$propertyTypeArr);//物业类型，如：新房，二手房，出租

		
		$priceArr = priceArray();
		$view_price = getKey($priceArr,$_GET['price']);
		$this->assign("priceArr",$priceArr);//价格区间
		
		$houseTypeArr = houseTypeArray();//房型
		$this->assign("houseTypeArr",$houseTypeArr);
		$view_houseType = getKey($houseTypeArr,$product["houseType"]);	
		$this->assign("view_houseType",$view_houseType);
		
		$areaArr = areaArray();
		$this->assign("areaArr",$areaArr);
		$view_area = getKey($areaArr,$_GET['useArea']);
		
		$directionArr = directionArray();
		$view_direction = getKey($directionArr,$product["direction"]);
		$this->assign("view_direction",$view_direction);
		
		$decorationArr = decorationArray();
		$view_decoration = getKey($decorationArr,$product["decoration"]);
		$this->assign("view_decoration",$view_decoration);
		
		
		//区域类型
		$district=M("District");
		$distList=$district->where("state=1")->select();
		$this->assign("distList", $distList);
		
		
		$condition1['id'] = $product["userID"];
		$condition1['state'] = 1;
		$Agent = D("Agent");
		$agent = $Agent->where($condition1)->find();
		$this->assign("agent", $agent);
		
		//$type = $_GET['type'];
		//$this->assign("type",$type);
		
		//图片
		$Picture = M("Picture");
		$picList = $Picture->where("productID=".$id." and state=1 and type=1")->select();
		$this->assign("picList",$picList);
		$this->assign("picNum",count($picList));
		
		
		Load('extend');//加载扩展函数库 字符串截取
		
		//SEO keywords、 description设置
		$title = "";
		$keywords = "";
		$page_description = $this->com["cityName"];
		$maxChar = 200;
		if($product["type"]==5){//租房
			$depositTypeArr = depositTypeArray();
			$view_depositType = getKey($depositTypeArr,$product["depositType"]);
			$this->assign("view_depositType",$view_depositType);//押金类型
                	
			$page_description = $product["address"]."。".$product["recommendation"]."。".Strip_tags($product["description"]);
			if( strlen($page_description) > $maxChar){
				$page_description = mb_substr($page_description,0,$maxChar,'utf-8');
			}
			
			$title = $product["productName"]." - ".$this->com["cityName"]."租房|".$this->com["abbreviation"];
			$keywords = $this->com["cityName"]."租房,".$this->com["cityName"]."房屋出租,".$this->com["cityName"]."出租房";
			
			$this->assign("title", $title);
			$this->assign("keywords", $keywords);
			$this->assign("page_description", $page_description);
			$this->display(APP_PATH.'/Tpl/default/Home/rent_view.html');	
			return;
		}elseif ($product["type"]==1){//新房
			//如果推荐说明小于20个字，再取房源说明的50个字作为recommendation
			$page_description = $product["address"].$product["recommendation"]."。".Strip_tags($product["description"]);
			if( strlen($page_description) > $maxChar){
				$page_description = mb_substr($page_description,0,$maxChar,'utf-8');
			}
			$title = $product["productName"]." - ".$this->com["cityName"]."新房|".$this->com["abbreviation"];
			$keywords = $this->com["cityName"]."新楼盘,".$this->com["cityName"]."新房,".$this->com["cityName"]."一手房";
		}elseif ($product["type"]==2){//二手房
			$page_description = $product["address"].$product["recommendation"]."。".Strip_tags($product["description"]);
			if( strlen($page_description) >$maxChar){
				$page_description = mb_substr($page_description,0,$maxChar,'utf-8');
			}
			$title = $product["productName"]." - ".$this->com["cityName"]."二手房|".$this->com["abbreviation"];
			$keywords = $this->com["cityName"]."二手房";
		} else {
			$page_description = $page_description.$product["address"].$product["recommendation"]."。".Strip_tags($product["description"]);
			if( strlen($page_description) > $maxChar){
				$page_description = mb_substr($page_description,0,$maxChar,'utf-8');
			}
			$title = $product["productName"]." - ".$this->com["cityName"]."|".$this->com["cityName"];
			$keywords = $this->com["cityName"].$this->com["companyName"];
		}
		$this->assign("title",$title);
		$this->assign("keywords",$keywords);
		$this->assign("page_description", $page_description);
		//SEO 结束
		
		//dump($distList);return;
		$this->display(APP_PATH.'/Tpl/default/Home/view.html');	
	}
	
	public function rentHouse(){		
		
		$price = $_GET['price'];
		$houseType = $_GET['houseType'];//一房一厅，二房一厅等。
		$keyWord = $_GET['keyWord'];
		$districtID = $_GET["dist"];//区域
		
		if(!empty($_GET['price'])){
			//echo "noEmpty";
			if($_GET['price'] == 1){
				//echo "1";
				$condition['product.rent'] = array('lt',500);
			}
			if($_GET['price'] == 2){
				//echo "2";
				$condition['product.rent'] = array(array('egt',500),array('elt',1000));
			}
			if($_GET['price'] == 3){
				//echo "3";
				$condition['product.rent'] = array(array('egt',1000),array('elt',1500));
			}
			if($_GET['price'] == 4){
				//echo "4";
				$condition['product.rent'] = array(array('egt',1500),array('elt',2500));
			}
			if($_GET['price'] == 5){
				//echo "4";
				$condition['product.rent'] = array(array('egt',2500),array('elt',3500));
			}
			
			if($_GET['price'] == 6){
				$condition['product.rent'] = array('gt',3500);
			}
		}
		
		//面积
		if(!empty($area)){
			//echo "noEmpty";
			if($area == 1){
				//echo "1";
				$condition['product.area'] = array('lt',40);
			}
			if($area == 2){
				//echo "2";
				$condition['product.area'] = array(array('egt',40),array('elt',60));
			}
			if($area == 3){
				//echo "3";
				$condition['product.area'] = array(array('egt',60),array('elt',80));
			}
			if($area == 4){
				//echo "4";
				$condition['product.area'] = array(array('egt',80),array('elt',100));
			}
			if($area == 5){
				//echo "4";
				$condition['product.area'] = array(array('egt',100),array('elt',120));
			}
			if($area == 6){
				//echo "5";
				$condition['product.area'] = array(array('egt',120),array('elt',144));
			}
			if($area == 7){
				$condition['product.area'] = array('gt',144);
			}
		}
		if(!empty($districtID)){
			$condition['product.districtID'] = $districtID;
		}
		
		$condition['product.state'] = 1;
		if(!empty($keyWord)){
	    	$condition['product.productName'] = array('like',"%".urldecode($keyWord)."%");
		}
		if(!empty($type)){
			$condition['product.type'] = $type;
		}
		
	    //记住查询参数
	    $this->assign("keyWord", urldecode($_GET['keyWord']));
	    $this->assign("totalPrice", $_GET['price']);
	    $this->assign("houseType", $_GET['houseType']);//一房一厅，二房一厅等
	    $this->assign("districtID", $districtID);		
		
		Load('extend');//加载扩展函数库 字符串截取
		
		//区域类型
		$district=M("District");
		$distList=$district->where("state=1")->select();
		$this->assign("distList", $distList);
		
		$priceArr = rentArray();
		$view_price = getKey($priceArr,$_GET['price']);
		$this->assign("priceArr",$priceArr);//价格区间
		
		$houseTypeArr = houseTypeArray();//房型
		$this->assign("houseTypeArr",$houseTypeArr);
		$view_houseType = getKey($houseTypeArr,$product["houseType"]);	
		$this->assign("view_houseType",$view_houseType);
		
		$propertyTypeArr = propertyTypeArray();
		$this->assign("propertyTypeArr",$propertyTypeArr);//物业类型，如：新房，二手房，出租
		
		$condition['product.state'] = 1;
		$condition['product.type'] = 5;//租房
		$Product = M("Product");
		$houseList = $Product->
			field("product.*,agent.sex,agent.mobile,agent.qq,agent.introduction,agent.headPic,agent.nickName" )-> 
			join('left JOIN agent ON product.userID = agent.id')->where($condition)->order('sort desc, id desc')->page($_GET['p'].',15')->select();
		
		for($i=0; $i<=count($houseList)-1; $i++){
			$condition31['productID'] = $houseList[$i]["id"];
			$condition31['state'] = 1;
			$condition31['type'] = 1;//产品类型图片
			$Picture = M("Picture");
			$pictureList = $Picture->where($condition31)->order('recommendation desc')->limit(1)->select();
			//dump(count($pictureList));
			//dump($pictureList);
			if($pictureList!=null && count($pictureList)>0){
				$houseList[$i]["picture"] = $pictureList[0]["thumb"];
			} 
		}
		
		//默认的租金菜单
		$priceArr = rentArray();
		$view_price = getKey($priceArr,$_GET['price']);
		$this->assign("view_price",$view_price);//默认显示的价格文字
		
		 //设置菜单默认选中
	    foreach($distList as $key =>$val) {
			if($val["id"] == $districtID){
				$view_distName = $val["name"];
			}
		}
		$this->assign("view_distName", $view_distName);
		
		$houseTypeArr = houseTypeArray();
		$this->assign("houseTypeArr",$houseTypeArr);
		$view_houseType = getKey($houseTypeArr,$_GET['houseType']);
		$this->assign("view_houseType",$view_houseType);//默认显示的房型文字
		
		//dump($houseList);
		$this->assign("rentHouseList", $houseList);
		
		import("ORG.Util.Page");// 导入分页类
		$count = $Product->where($condition)->count('id');// 查询满足要求的总记录数
		$Page = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		
		$this->display(APP_PATH.'/Tpl/default/Home/rentHouse.html');	
	}
	

}
?>