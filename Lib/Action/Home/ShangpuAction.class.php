<?php
class ShangpuAction extends HomeBaseAction {

	public function index(){
		
		Load('extend');//加载扩展函数库 字符串截取
		
		$condition['product.state'] = 1;
		$condition['product.type'] = 3;//商铺
		//echo $_GET['saletype'];return;
		$saleType = 1;
		$title = "商铺出租";
		if(empty($_GET['saletype']) || $_GET['saletype']==1){
			$condition['product.saleType'] = 1;//出租
		} else if($_GET['saletype']==2){
			$condition['product.saleType'] = 2;//转让
			$saleType = 2;
			$title = "商铺转让";
		}
		$this->assign("saleType", $saleType);
		$this->assign("title", $title);
		
		
		$Product = M("Product");
		$shangpuList = $Product->
			field("product.*,agent.sex,agent.mobile,agent.qq,agent.introduction,agent.headPic,agent.nickName" )-> 
			join('left JOIN agent ON product.userID = agent.id')->where($condition)->order('sort desc, id desc')->page($_GET['p'].',15')->select();
		
		for($i=0; $i<=count($shangpuList)-1; $i++){
			$condition31['productID'] = $shangpuList[$i]["id"];
			$condition31['state'] = 1;
			$condition31['type'] = 1;//产品类型图片
			$Picture = M("Picture");
			$pictureList = $Picture->where($condition31)->order('recommendation desc')->limit(1)->select();
			//dump(count($pictureList));
			//dump($pictureList);
			if($pictureList!=null && count($pictureList)>0){
				$shangpuList[$i]["picture"] = $pictureList[0]["thumb"];
			} 
		}
		
		$this->assign("shangpuList", $shangpuList);
		
		import("ORG.Util.Page");// 导入分页类
		$count = $Product->where($condition)->count('id');// 查询满足要求的总记录数
		$Page = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		
		$this->display(APP_PATH.'/Tpl/default/Home/shangpu.html');	
	}
	
	function view(){
		$id = $_GET['id'];
		if(empty($id)) {
			$this->error("房源不存在！");	
		}

		$ProductDao = M("Product");
		$condition['id'] = $id;
		$condition['state'] = 1;
		$product = $ProductDao->where($condition)->find();
		if(empty($product)){
			$this->error("商铺不存在！");	
			return;
		}
		$this->assign("product",$product);
		
	
		
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

		$page_description = $product["address"]."。".$product["recommendation"]."。".Strip_tags($product["description"]);
		if( strlen($page_description) > $maxChar){
			//echo "大于200".strlen($page_description);
			$page_description = mb_substr($page_description,0,$maxChar,'utf-8');
		} else {
			//echo "小于200,".strlen($page_description);
		}
		
		$proTypeName = "商铺出租";
		if($product['saleType']==1){
			$title = $product["productName"]." - ".$this->com["cityName"]."商铺出租|".$this->com["abbreviation"];
			$keywords = $this->com["cityName"]."商铺,".$this->com["cityName"]."商铺出租";
		} elseif ($product['saleType']==2){
			$title = $product["productName"]." - ".$this->com["cityName"]."商铺转让|".$this->com["abbreviation"];
			$keywords = $this->com["cityName"]."商铺,".$this->com["cityName"]."商铺转让";
			$proTypeName = "商铺转让";
		}
		
		$this->assign("proTypeName", $proTypeName);
		$this->assign("title",$title);
		$this->assign("keywords",$keywords);
		$this->assign("page_description", $page_description);
		//SEO 结束
		
		//装修
		$decorationArr = decorationArray();
		$view_decoration = getKey($decorationArr,$product["decoration"]);
		$this->assign("view_decoration",$view_decoration);
		
		//dump($distList);return;
		$this->display(APP_PATH.'/Tpl/default/Home/shangpu_view.html');	
	}
}
?>