<?php
class CachemangerAction extends AdminBaseAction {
		
	// 清除缓存目录
	function clearCache($type=0,$path=NULL) {
//	        if(is_null($path)) {
//	            switch($type) {
//	            case 0:// 模版缓存目录
//	                $path = CACHE_PATH;
//	                break;
//	            case 1:// 数据目录
//	                $path   =   DATA_PATH;
//	            }
//	        }
	        import("ORG.Io.Dir");
	        echo "==".$path;
	        Dir::del($path);
	}
	
	function abc(){
		echo "1";
	}
	
	function clearMyCache(){
		import("ORG.Io.Dir");
		
		$Cachepath = RUNTIME_PATH;
		$path_cache = $Cachepath.'Cache';
		echo $path_cache;
		if(!Dir::isEmpty($path_cache)){
			
        	Dir::delDir($path_cache);
        	//echo "1111111111".$path_cache;return;
		}
		$path_Data = $Cachepath.'Data';
		$path_Temp = $Cachepath.'Temp';
		$path_app = $Cachepath.'~app.php';
		$path_runtime = $Cachepath.'~runtime.php';
		
		if(!Dir::isEmpty($path_Temp)){	
        	Dir::delDir($path_Temp);
		}
		if(!Dir::isEmpty($path_Data)){
        	Dir::delDir($path_Data);
		}
        if(!Dir::isEmpty($path_app)){
        	Dir::del($path_app);
        }
        if(!Dir::isEmpty($path_runtime)){
        	Dir::del($path_runtime);
        }
		
        //$this->assign('jumpUrl', U("Admin-Index/show"));
        //$this->success('删除成功');
     	$this->redirect('Admin-Index/show');//重定向到列表方法。
	}
	
	
		 	
}
?>