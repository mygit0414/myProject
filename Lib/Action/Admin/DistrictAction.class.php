<?php
/**
 * 区域自定义控制器，网站下的城市区域由用户自己创建。
 */


class DistrictAction extends AdminBaseAction {

	/**
	 * 显示已定义的区域 
	 */
	public function index(){
		$district=M("District");
		$distList=$district->where("state=1")->order("id desc")->select();
		//dump($data);
		$this->assign("distList", $distList);
		$this->display( APP_PATH.'/Tpl/default/Admin/district/list.html');
	}
	
	/**
	 * 跳转到新增自定义的页面
	 */
	public function add(){
		$this->display(APP_PATH.'/Tpl/default/Admin/district/add.html');
	}
	
	function insert(){
		$district=M("District");
		$district->create();
		//$this->success('数据保存成功！');
		$district->add();
		$this->redirect("index") ;//重定向到列表方法。
	}
	
	
	// 更新数据
	public function update() {
		$District	=	D("District");
		if($vo = $District->create()) {
			$list=$District->save();
			if($list!==false){
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error("没有更新任何数据!");
			}
		}else{
			$this->error($District->getError());
		}
	}
	// 删除数据
	public function delete() {
		if(!empty($_GET['id'])) {
			$Form	=	M("District");
			$result	=	$Form->delete($_GET['id']);
			if(false !== $result) {
				$this->ajaxReturn($_GET['id'],'删除成功！',1);
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}

	// 编辑数据 | 跳到更新页面
	public function edit() {
		if(!empty($_GET['id'])) {
			$Form	=	M("District");
			$vo	=	$Form->where("state=1")->select($_GET['id']);
			//$vo	=	$Form->getById($_GET['id']);
			//echo $vo[0];
			//dump($vo);
			if($vo && $vo[0]) {
				$this->assign('vo',$vo[0]);
				$this->display(APP_PATH.'/Tpl/default/Admin/district/edit.html');
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
	}
}
?>