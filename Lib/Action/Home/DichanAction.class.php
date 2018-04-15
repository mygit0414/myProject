<?php
class DichanAction extends HomeBaseAction {
	
	function index(){
		Load('extend');//加载扩展函数库 字符串截取

		$condition['product.state'] = 1;
		
		$saleType = 1;
		$saleTypeName = "";
		if(empty($_GET['saletype']) || $_GET['saletype']==1){
			$condition['product.saleType'] = 1;//出租
			$saleTypeName = "出租";
		} else if($_GET['saletype']==2){
			$condition['product.saleType'] = 2;//转让
			$saleType = 2;
			$saleTypeName = "转让";
		}
		
		$typeLink = "dichan";
		$typeName = "厂房/仓库/地皮";
		$title = $typeName;
		$keywords = "";
		
		if($_GET['type']==6){
			$condition['type'] = 6;//厂房
			$typeLink = "changfang";
			$typeName = "厂房";
			$keywords = $this->com["cityName"].$typeName.$saleTypeName;
			$title = "厂房";
		} else if($_GET['type']==7){
			$condition['type'] = 7;//地皮
			$typeLink = "dipi";
			$typeName = "地皮";
			$keywords = $this->com["cityName"].$typeName.",".$this->com["cityName"]."地皮".$saleTypeName;
			$title = "地皮";
		} else if($_GET['type']==8){
			$condition['type'] = 8;//仓库
			$typeLink = "cangku";
			$typeName = "仓库";
			$keywords = $this->com["cityName"].$typeName.$saleTypeName;
			$title = "仓库";
		} else if($_GET['type']==10){
			$condition['type'] = 10;//其它
			$typeLink = "qitadc";
			$typeName = "";
			$keywords = "";
			$title = "其他地产";
		} else {
			$condition['type'] = array(array('eq',6),array('eq',7), array('eq',8), array('eq',10), 'or') ;
			$keywords = $this->com["cityName"]."厂房,仓库,地皮,".$saleTypeName;
		}

		$description = "提供大量最新".$this->com["cityName"].$typeName.$saleTypeName."信息,需要".$saleTypeName.$typeName.",请找".$this->com['abbreviation'].",联系电话：".$this->com['tel'].".";
		if($_GET['type']==10){
			$description = "提供大量最新".$this->com["cityName"]."其他地产信息,需要".$saleTypeName."各类地产,请找".$this->com['abbreviation'].",联系电话：".$this->com['tel'].".";
		}
		$this->assign("type", $_GET['type']);
		$this->assign("typeLink",$typeLink);
		$this->assign("typeName",$typeName);//title,
		$this->assign("title", $title);
		$this->assign("keywords", $keywords);
		$this->assign("description", $description);
		
		$this->assign("saleTypeName",$saleTypeName);
		$this->assign("saleType", $saleType);
		$this->assign("title", $title);
		
		
		$Product = M("Product");
		$dichanList = $Product->
			field("product.*,agent.sex,agent.mobile,agent.qq,agent.introduction,agent.headPic,agent.nickName" )-> 
			join('left JOIN agent ON product.userID = agent.id')->where($condition)->order('sort desc, id desc')->page($_GET['p'].',15')->select();
		
		for($i=0; $i<=count($dichanList)-1; $i++){
			$condition31['productID'] = $dichanList[$i]["id"];
			$condition31['state'] = 1;
			$condition31['type'] = 1;//产品类型图片
			$Picture = M("Picture");
			$pictureList = $Picture->where($condition31)->order('recommendation desc')->limit(1)->select();
			//dump(count($pictureList));
			//dump($pictureList);
			if($pictureList!=null && count($pictureList)>0){
				$dichanList[$i]["picture"] = $pictureList[0]["thumb"];
			} 
		}
		
		$this->assign("dichanList", $dichanList);
		
		import("ORG.Util.Page");// 导入分页类
		$count = $Product->where($condition)->count('id');// 查询满足要求的总记录数
		$Page = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		
		//echo "00000000";
		$this->display(APP_PATH.'/Tpl/default/Home/dichanList.html');	
	}
	
	
	function view(){
		$id = $_GET['id'];
		if(empty($id)) {
			$this->error("地产信息不存在！");	
		}

		$ProductDao = M("Product");
		$condition['id'] = $id;
		$condition['state'] = 1;
		$product = $ProductDao->where($condition)->find();
		if(empty($product)){
			$this->error("地产信息不存在！");	
			return;
		}
		$this->assign("product",$product);

		$condition1['id'] = $product["userID"];
		$condition1['state'] = 1;
		$Agent = D("Agent");
		$agent = $Agent->where($condition1)->find();
		$this->assign("agent", $agent);
		
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

		$page_description = $product["address"]."。".$product["recommendation"]."。".Strip_tags($product["description"]);
		if( strlen($page_description) > $maxChar){
			//echo "大于200".strlen($page_description);
			$page_description = mb_substr($page_description,0,$maxChar,'utf-8');
		} else {
			//echo "小于200,".strlen($page_description);
		}
		
		$proTypeName = getKey(propertyTypeArray(),$product['type']);
		$priceType = "价格";
		if($product['saleType']==1){
			$title = $product["productName"]." - ".$this->com["cityName"].$proTypeName."出租|".$this->com["abbreviation"];
			$keywords = $this->com["cityName"].$proTypeName.",".$this->com["cityName"].$proTypeName."出租";
			$priceType = "租金";
		} elseif ($product['saleType']==2){
			$title = $product["productName"]." - ".$this->com["cityName"].$proTypeName."转让|".$this->com["abbreviation"];
			$keywords = $this->com["cityName"].$proTypeName.",".$this->com["cityName"].$proTypeName."转让";
			$priceType = "售价";
		}
		
		if($product['type']==10){//其它类型
			$keywords = $product["productName"];
			$proTypeName = "";
		}
		
		$this->assign("priceType",$priceType);
		$this->assign("proTypeName", $proTypeName);
		$this->assign("title",$title);
		$this->assign("keywords",$keywords);
		$this->assign("page_description", $page_description);
		//SEO 结束
		
		//dump($distList);return;
		$this->display(APP_PATH.'/Tpl/default/Home/dichan_view.html');	
	}
}

?>