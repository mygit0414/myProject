<?php
class NewsAction extends HomeBaseAction {
	
	function index(){
		$news = M("News");
		$newsList=$news->where("state=1")->page($_GET['p'].',8')->order("id desc")->select();
		//dump($data);
		$this->assign("newsList", $newsList);
		
		$this->display( APP_PATH.'/Tpl/default/Home/news/newsList.html');
	}
	
	function view(){
		$id = $_GET['id'];
		if(empty($id)) {
			$this->error("资讯不存在！");	
			return;
		}
		
		$NewsDao = M("News");
		$condition['id'] = $id;
		$condition['state'] = 1;
		$news = $NewsDao->where($condition)->find();
		if(empty($news)){
			$this->error("资讯不存在！");	
			return;
		}
		$this->assign("news",$news);
		
		Load('extend');//加载扩展函数库 字符串截取
		
		$page_description = Strip_tags($news["content"]);
		$this->assign("page_description", $page_description);
		
		$this->display( APP_PATH.'/Tpl/default/Home/news/news.html');
	}
}
?>