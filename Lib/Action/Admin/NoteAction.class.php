<?php
class NoteAction extends AdminBaseAction {
	
	public function index(){
		$note = M("Note");
		$noteList=$note->where("state=1")->page($_GET['p'].',15')->order("id desc")->select();
		//dump($data);
		$this->assign("noteList", $noteList);
		
		$this->display( APP_PATH.'/Tpl/default/Admin/note/list.html');
	}
	
/**
	 * 跳转到新增自定义的页面
	 */
	public function add(){
		$this->display(APP_PATH.'/Tpl/default/Admin/note/add.html');
	}
	
	function insert(){
		
		//增加记录
		$note=M("Note");
		$note->create();
		$note->createDate=date("Y-m-d");
		$note->userID=Session::get('loginID');
		$id = $note->add();
		if(!$id){
			$this->error("写入数据失败");
		}
				
		$this->redirect("index") ;//重定向到列表方法。
		
	}
	
	// 删除数据
	public function delete() {
		if(!empty($_GET['id'])) {
			$note	=	M("Note");
			$note->id=$_GET['id'];
			$note->state=-1;
			$result	=	$note->save();
			if(false !== $result) {
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error('删除出错！');
			}
		}else{
			$this->error('删除项不存在！');
		}
	}
	
	//编辑数据 | 跳到更新页面
	public function edit() {
		if(!empty($_GET['id'])) {
			$note	=	M("note");
			$vo	=	$note->where("state=1")->select($_GET['id']);
			//$vo	=	$Form->getById($_GET['id']);
			//echo $vo[0];
			//dump($vo);
			if($vo && $vo[0]) {
				$this->assign('vo',$vo[0]);
				$this->display(APP_PATH.'/Tpl/default/Admin/note/edit.html');
			}else{
				exit('编辑项不存在！');
			}
		}else{
			exit('编辑项不存在！');
		}
	}
	
	// 更新数据
	public function update() {
		import('ORG.Net.UploadFile');
		if (empty($_POST['id'])){
			$this->error("编辑失败，缺少主键ID");
			return;
		}

		$note = D("note");
		
		if($vo = $note->create()) {
			
			$list=$note->save();
			if($list!==false){
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error("没有更新任何数据!");
			}
		}else{
			$this->error($note->getError());
		}
		
	}
}
?>