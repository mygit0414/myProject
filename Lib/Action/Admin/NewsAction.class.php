<?php
class NewsAction extends AdminBaseAction {

	public function index(){
		$news = M("News");
		$newsList=$news->where("state=1")->page($_GET['p'].',15')->order("id desc")->select();
		//dump($data);
		$this->assign("newsList", $newsList);
		
		$this->display( APP_PATH.'/Tpl/default/Admin/news/list.html');
	}
	
	/**
	 * 跳转到新增自定义的页面
	 */
	public function add(){
		$this->display(APP_PATH.'/Tpl/default/Admin/news/add.html');
	}
	
	function insert(){
		
		//增加记录
		$news=M("News");
		$news->create();
		$news->state=1;
		$news->createDate=date("Y-m-d");
		$news->userID=Session::get('loginID');
		$news->userName=Session::get('loginName');;//图片路径.
		$id = $news->add();
		if(!$id){
			$this->error("写入数据失败");
		}
		
		//图片
		import('ORG.Net.UploadFile');
		
		$uploadPath = 'Public/Uploads/news/'.date("Ymd").'/';
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  $uploadPath;// 设置附件上传目录
		$upload->saveRule = uniqid;//文件名规则
		$upload->uploadReplace = true;
		$upload->thumb = false;
	    //$upload->thumbMaxWidth = '144';//多张用,多张用逗号隔开。
	   // $upload->thumbMaxHeight = '130';
		if(!$upload->upload()) {// 上传错误提示错误信息
			//$this->error($upload->getErrorMsg());
		}else{// 上传成功 获取上传文件信息
			$fileNameAll = $_REQUEST['fileName'];
			$fileName = array();
			$tempIndex = 0;

			$info =  $upload->getUploadFileInfo();
			//echo count($info);
			$fileNum = $_FILES['file']['size'];//上传文件个数
			for($j=0; $j<count($fileNum); $j++){
				if($fileNum[$j]>0){
					$fileName[$tempIndex]=$fileNameAll[$j];
					$tempIndex++;
				}
			}
			//echo "上传文件个数：".count($fileNum);
			//echo "count:".count($info);
			//echo "dump".dump($info);
			//return;
			for($i=0; $i<count($info); $i++){  
        		//echo $info[$i]['savename'];
        		$picture = M("Picture");
        		$picture->productID=$id;
				$picture->bigPicUrl="/".$uploadPath.$info[$i]['savename'];
				//$picture->thumb="/".$uploadPath.'thumb_'.$info[$i]['savename'];
				$picture->uploadDate=date("Y-m-d H:i:s");;
				$picture->title=$fileName[$i];//指定的文件名称。
				$picture->state=1;
				$picture->userID=Session::get('loginID');
				$picture->userName=Session::get('loginName');;//图片路径.
				$picture->type=2;//新闻类型图片
				
				$picture->add();        		
            }
	   }
				
		$this->redirect("index") ;//重定向到列表方法。
		
	}
	
	// 删除数据
	public function delete() {
		if(!empty($_GET['id'])) {
			$News	=	M("News");
			$News->id=$_GET['id'];
			$News->state=-1;
			$News->update=Session::get('loginID');
			$result	=	$News->save();
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
			$News =	M("News");
			$vo	= $News->where("state=1")->select($_GET['id']);
			//$vo	=	$Form->getById($_GET['id']);
			//echo $vo[0];
			//dump($vo);
			Load('extend');//加载扩展函数库
			if($vo && $vo[0]) {
				$this->assign('vo',$vo[0]);
				//图片
				$Picture = M("Picture");
				$picList = $Picture->where("productID=".$_GET['id']." and state=1 and type=2")->select();
				$this->assign("picList",$picList);
		
				$this->display(APP_PATH.'/Tpl/default/Admin/news/edit.html');
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

		$News = D("News");
		
		if($vo = $News->create()) {
			
			$list=$News->save();
			if($list!==false){
				import('ORG.Net.UploadFile');
				if (empty($_POST['id'])){
					$this->error("编辑失败，缺少主键ID");
					return;
				}
				
				$picPath = null;
				$info = null;
				$uploadPath = 'Public/Uploads/news/'.date("Ymd").'/';
				$upload = new UploadFile();// 实例化上传类
				$upload->maxSize  = 3145728 ;// 设置附件上传大小
				$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
				$upload->savePath =  $uploadPath;// 设置附件上传目录
				$upload->saveRule = uniqid;//文件名规则
				$upload->uploadReplace = true;
				$upload->thumb = false;
				if(!$upload->upload()) {// 上传错误提示错误信息
					//如果增加了文件上传框却没有选择上传文件，也会出错，因此，这里出错不进行处理。
					//echo "上传错误";
					//$this->error($upload->getErrorMsg());
					//return;
				    //上传失败不要直接返回，有可能是没有选择上传文件。
				}else{// 上传成功 获取上传文件信息
					$fileNameAll = $_REQUEST['fileName'];
					$fileName = array();
					$tempIndex = 0;
					$info =  $upload->getUploadFileInfo();
					//echo count($info);
					$fileNum = $_FILES['file']['size'];//上传文件个数
					for($j=0; $j<count($fileNum); $j++){
						if($fileNum[$j]>0){
							$fileName[$tempIndex]=$fileNameAll[$j];
							$tempIndex++;
						}
					}
		
					for($i=0; $i<count($info); $i++){  
						echo $i;
		        		//echo $info[$i]['savename'];
		        		$picture = M("Picture");
		        		$picture->productID=$_POST['id'];
						$picture->bigPicUrl="/".$uploadPath.$info[$i]['savename'];
						$picture->thumb="/".$uploadPath.'thumb_'.$info[$i]['savename'];
						$picture->uploadDate=date("Y-m-d H:i:s");;
						$picture->title=$fileName[$i];//指定的文件名称。
						$picture->state=1;
						$picture->userID=Session::get('loginID');
						$picture->userName=Session::get('loginName');;//图片路径.
						$picture->type=2;//产品类型图片
						$picture->add();        		
		            }
			   }
				//删除图片
				$delPicID=$_POST['delPicID'];
				if(!empty($delPicID)){
					$picID = explode(",",$delPicID);
					for($i=0; $i<count($picID); $i++){
						$Picture = M("Picture");
						$Picture->id=$picID[$i];
						$Picture->state=-1;
						
						$result	= $Picture->save();
					}
				}
		
				$this->redirect("index") ;//重定向到列表方法。
			}else{
				$this->error("没有更新任何数据!");
			}
		}else{
			$this->error($News->getError());
		}
		
	}
}
?>