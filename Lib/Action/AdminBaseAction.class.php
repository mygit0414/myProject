<?php
class AdminBaseAction extends Action{
	function  _initialize(){
			//echo "_initialize()";
			//echo "cookie=".$_COOKIE['loginName'];
		    //echo "session=".$_SESSION['loginName']; // 删除name
	        //echo "session1=".Session::get('loginName')."<br/>";
		
		$Company = M("Company");
		$com = $Company->find(1);
		//dump($comVO);return;
		$this->assign("com",$com);
		
		if(Cookie::is_set('loginName')){
			//$loginID = Cookie::get('loginID');
			//$loginName = Cookie::get('loginName');
			//echo "有cookie".$loginID.$loginName."<br/>";
			Session::set('loginID',Cookie::get('loginID'));//设置session
			Session::set('loginName', Cookie::get('loginName'));
			return;
		}
		
		if(Session::is_set('loginName')){
            //echo 'is set sessoin';
		}else{
		    //echo 'not set session';
			$this->redirect('Login/index');
		}
		return ;
	}
	
	/**
	 * 编辑，删除权限判断
	 * Enter description here ...
	 */
	function udAuth(){
		$this->userID=Session::get('loginID');
		$Product = M("Product");
		
		$this->id = $_GET['id'];
        //echo "GET=".$this->id ;
        //echo "isset=".isset($this->id)."<br/>";
		if(!isset($_GET['id'])){
			$this->id = $_POST['id'];
			//echo "post=".$this->id ;
		}

        if(!empty($this->id)){
            //echo "id2=".$this->id;
			$this->error("出错了，原因：主键ID为空");
			return;
		}


		$vo	= $Product->select($this->id);

		if(empty($vo) || empty($vo[0]) || $vo[0]["state"]==-1){
//            dump($vo);
//
//            if(true){
//                return;
//            }
			$this->error("产品不存在，ID=".$this->id);
			return;
		}

		if($vo[0]["userID"]!=$this->userID && $this->userID!=1){
			$this->error(Session::get('loginName').",权限不足.");
			return;
		}
	}
}
