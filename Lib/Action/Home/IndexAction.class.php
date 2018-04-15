<?php
// 本文档自动生成，仅供测试运行
class IndexAction extends HomeBaseAction {
    /**
    +----------------------------------------------------------
    * 默认操作
    +----------------------------------------------------------
    */
    public function index()
    {
    	
    	//$Company = M("Company");
		//$this->com	=	$Company->find(1);
		//dump($this->comVO);return;
		//$this->assign("com",$this->com);
		
		$propertyTypeArr = propertyTypeArray();
		$this->assign("propertyTypeArr",$propertyTypeArr);//物业类型，如：新房，二手房，出租
		
		$priceArr = priceArray();
		$this->assign("priceArr",$priceArr);//价格区间
		
		$houseTypeArr = houseTypeArray();
		$this->assign("houseTypeArr",$houseTypeArr);
		
		$areaArr = areaArray();
		$this->assign("areaArr",$areaArr);
		
		$district=M("District");
		$distList=$district->where("state=1")->select();
		$this->assign("distList", $distList);
		
		$condition['state'] = 1;
		$condition['type'] = 1;//新房
		$Product = M("Product");
		$houseList = $Product->where($condition)->order('sort desc, id desc')->page('1,4')->select();
		//$Product->getLastSql();
		
		for($i=0; $i<=count($houseList)-1; $i++){
			$condition1['productID'] = $houseList[$i]["id"];
			$condition1['state'] = 1;
			$condition1['type'] = 1;//产品类型图片
			$Picture = M("Picture");
			$pictureList = $Picture->where($condition1)->order('recommendation desc')->limit(1)->select();
			//dump(count($pictureList));
			//dump($pictureList);
			if($pictureList!=null && count($pictureList)>0){
				$houseList[$i]["picture"] = $pictureList[0]["thumb"];
			} 
		}
		//dump($houseList);
		$this->assign("houseList", $houseList);
		
		$condition2['state'] = 1;
		$condition2['type'] = 2;//二手房
		$Product = M("Product");
		$houseList = $Product->where($condition2)->order('id desc')->page('1,4')->select();
		//$Product->getLastSql();
		
		for($i=0; $i<=count($houseList)-1; $i++){
			$condition21['productID'] = $houseList[$i]["id"];
			$condition21['state'] = 1;
			$condition21['type'] = 1;//产品类型图片
			$Picture = M("Picture");
			$pictureList = $Picture->where($condition21)->order('recommendation desc')->limit(1)->select();
			//dump(count($pictureList));
			//dump($pictureList);
			if($pictureList!=null && count($pictureList)>0){
				$houseList[$i]["picture"] = $pictureList[0]["thumb"];
			} 
		}
		//dump($houseList);
		$this->assign("secondHouseList", $houseList);
		
		$condition3['product.state'] = 1;
		$condition3['product.type'] = 5;//租房
		$Product = M("Product");
		$houseList = $Product->
			field("product.*,agent.sex,agent.mobile,agent.qq,agent.introduction,agent.headPic,agent.nickName" )-> 
			join('left JOIN agent ON product.userID = agent.id')->where($condition3)->order('product.id desc')->page('1,4')->select();
		
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
		//dump($houseList);
		$this->assign("rentHouseList", $houseList);
		
		$condition4['product.state'] = 1;
		$condition4['product.type'] = 3;//商铺
		$Product = M("Product");
		$shangpuList = $Product->
			field("product.*,agent.sex,agent.mobile,agent.qq,agent.introduction,agent.headPic,agent.nickName" )-> 
			join('left JOIN agent ON product.userID = agent.id')->where($condition4)->order('product.id desc')->page('1,4')->select();
		
		for($i=0; $i<=count($shangpuList)-1; $i++){
			$condition41['productID'] = $shangpuList[$i]["id"];
			$condition41['state'] = 1;
			$condition41['type'] = 1;//产品类型图片
			$Picture = M("Picture");
			$pictureList = $Picture->where($condition41)->order('recommendation desc')->limit(1)->select();
			//dump(count($pictureList));
			//dump($pictureList);
			if($pictureList!=null && count($pictureList)>0){
				$shangpuList[$i]["picture"] = $pictureList[0]["thumb"];
			} 
		}
		//dump($houseList);
		$this->assign("shangpuList", $shangpuList);
		
		$this->assign("indexPage","index");
		
		Load('extend');//加载扩展函数库 字符串截取
		C('TOKEN_ON',false); //关闭表单令牌验证.
    	$this->display(APP_PATH.'/Tpl/default/Home/homeIndex.html');
    }

    /**
    +----------------------------------------------------------
    * 探针模式
    +----------------------------------------------------------
    */
    public function checkEnv()
    {
        load('pointer',THINK_PATH.'/Tpl/Autoindex');//载入探针函数
        $env_table = check_env();//根据当前函数获取当前环境
        echo $env_table;
    }
    
    public function homeIndex(){
    	
    }

    public function about(){
		//$Company = M("Company");
		//$this->com	=	$Company->find(1);
		//dump($this->comVO);return;
		//$this->assign("com",$this->com);
     	$this->display(APP_PATH.'/Tpl/default/Home/about.html');
    }
    
	public function link(){
		
     	$this->display(APP_PATH.'/Tpl/default/Home/about.html');
    }
}
?>