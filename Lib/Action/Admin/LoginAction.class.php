<?php
class LoginAction extends Action {
	
	public function index(){
		
		if(!empty($_GET['flag'])){
			if($_GET['flag']==1) {
				$this->assign('loginMessage',"请输入用户名");
			}
			
			if($_GET['flag']==2) {
				$this->assign('loginMessage',"请输入密码");
			}
			
			if($_GET['flag']==3) {
					$this->assign('loginMessage',"用户不存在");
			}
			if($_GET['flag']==4) {
				$this->assign('loginMessage',"密码错误");
			}
		}
		
		$Company = M("Company");
		$com = $Company->find(1);
		//dump($comVO);return;
		$this->assign("com",$com);
		
		$this->display(APP_PATH.'/Tpl/default/Admin/login.html');
	}
	
	public function checkLogin(){

		if(empty($_POST['loginName'])) {
			$this->redirect("index",array('flag' => 1)) ;//重定向到列表方法。
		}
		if(empty($_POST['password'])) {
			$this->redirect("index",array('flag' => 2)) ;//重定向到列表方法。
		}
		$md5pwd = MD5($_POST['password']);
		$Agent	=	M("Agent");
		
		$condition['loginName'] = $_POST['loginName'];
		$condition['state'] = '1';
		$agentVO = $Agent->where($condition)->find();
		//echo  $agentVO['password'];return;
		if(empty($agentVO)){
			$this->redirect("index",array('flag' => 3)) ;//用户不存在。重定向到列表方法。
		}
		//echo $agentVO->password."|".$md5pwd;return ;
		if($agentVO['password']!==$md5pwd){
			$this->redirect("index",array('flag' => 4)) ;//密码不正确。重定向到列表方法。
		}
		
		
		$PersistentCookie = $_POST['PersistentCookie'];
		//echo $_POST['PersistentCookie'];
		if(!empty($_POST['PersistentCookie']) && $_POST['PersistentCookie']=="1") {//记住密码
			if(!empty($agentVO['loginName'])){
				Cookie::set('loginID',$agentVO['id'],60*60*24*5); // 指定cookie保存时间 5天
				Cookie::set('loginName',$agentVO['loginName'],60*60*24*5); // 指定cookie保存时间 5天
				Session::set('loginID',$agentVO['id']);//设置session
				Session::set('loginName',$agentVO['loginName']);//设置session
			}
		} else {
            //echo $agentVO['id'];
			Session::set('loginID',$agentVO['id']);//设置session
			Session::set('loginName',$agentVO['loginName']);//设置session
            echo 'set session,loginID:'.Session::get('loginID');;
           // return;
		}
        //echo 'password error';
		$this->redirect("Index/show") ;//密码不正确。重定向到列表方法。
		
	}
	
	
	/**
	 * 退出系统
	 */
	public function loginOut(){
		Session::set('loginName',null);
		Cookie::delete('loginName');
		$this->redirect("Login/index") ;//密码不正确。重定向到列表方法
	}
	
}
?>