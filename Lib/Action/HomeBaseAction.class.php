<?php
class HomeBaseAction extends Action {
	function  _initialize(){
		
		/**
		*以下是搜索需要到的基础数据
		*/
		$Company = M("Company");
		$com = $Company->find(1);
		//dump($comVO);return;
		$this->assign("com",$com);
		
		$agent=M("Agent");
		$agentList=$agent->where("state=1 and loginName!='admin'")->order('sort desc')->limit(5)->select();
		//dump($agentList);
		$this->assign("agentList", $agentList);
		
		//公告管理
		$note=M("Note");
		$noteList=$note->where("state=1")->order('id desc')->limit(3)->select();
		$this->assign("noteList", $noteList);
		//dump($noteList);
		//return;
		
		//新闻资讯
		$news = M("News");
		$newsList=$news->where("state=1")->page('1,6')->order("id desc")->select();
		//dump($data);
		$this->assign("newsList", $newsList);
		
		//顶部banner
		$ad = M("Ad");
		$cond_ad['state'] = 1;
		$cond_ad['type'] = 1;//banner
		$ad=$ad->where($cond_ad)->limit(1)->select();
		if(count($ad>=1)){
			$this->assign("banner", $ad[0]);
		}
	}
}
?>