<?php
class TuangouAction extends HomeBaseAction {
	
	public function index(){
		$condition['product.state'] = 1;
		$condition['type'] = 9;
		
		$Product = M("Product");
//		$houseList = $Product->where($condition)->page($_GET['p'].',15')->select();
		$houseList = $Product->
			field("product.*,agent.sex,agent.mobile,agent.qq,agent.introduction,agent.headPic,agent.nickName" )-> 
			join('left JOIN agent ON product.userID = agent.id')->
			where($condition)->order('product.id desc' )->page($_GET['p'].',5')->select();
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
		import('ORG.Util.Date');// 导入日期类
		for($i=0; $i<count($houseList); $i++){  
			$houseList[$i]["applyEndTime"] = strtotime($houseList[$i]["applyEndTime"]);
			if($houseList[$i]["applyEndTime"]){
				$Date = new Date();
				$houseList[$i]["end"] = $Date->dateDiff($houseList[$i]["applyEndTime"],'d');  // 比较日期差
			}
			
		}
		$this->assign("houseList", $houseList);
		import("ORG.Util.Page");// 导入分页类
		$count = $Product->where($condition)->count('id');// 查询满足要求的总记录数
		$Page = new Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		
		$this->assign("tuanPage", 1);//右边区域判断用

		$this->display(APP_PATH.'/Tpl/default/Home/tuangou/index.html');
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
			$this->error("团购不存在！");	
			return;
		}
		
		import('ORG.Util.Date');// 导入日期类
		$product["applyEndTime"] = strtotime($product["applyEndTime"]);
		if($product["applyEndTime"]){
			$Date = new Date();
			$product["end"] = $Date->dateDiff($product["applyEndTime"],'d');  // 比较日期差
		}
		$this->assign("product",$product);
		
		$condition1['id'] = $product["userID"];
		$condition1['state'] = 1;
		$Agent = D("Agent");
		$agent = $Agent->where($condition1)->find();
		$this->assign("agent", $agent);
		
		
		$page_description = $product["recommendation"]." ".Strip_tags($product["description"]);
		//echo $page_description;return;
		$this->assign("page_description", $page_description);
		//$type = $_GET['type'];
		//$this->assign("type",$type);
		
		//图片
		$Picture = M("Picture");
		$picList = $Picture->where("productID=".$id." and state=1 and type=1")->select();
		$this->assign("picList",$picList);
		
		Load('extend');//加载扩展函数库 字符串截取
		$this->display(APP_PATH.'/Tpl/default/Home/tuangou/view.html');
	}
}

?>