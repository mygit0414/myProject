<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
$uri = $_SERVER["REQUEST_URI"];
//echo $uri;
//echo "<br/>";
if(stristr($uri,"/index.php/")){

    $uri2 = str_replace("/index.php/", "", $uri);
    //echo $uri2;
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /".$uri2);
}

// 定义ThinkPHP框架路径
define('THINK_PATH', './ThinkPHP');
//定义项目名称和路??
define('APP_NAME', 'jfhome2');
define('APP_PATH', '.');
define('NO_CACHE_RUNTIME',true);
// 加载框架公共入口文件
require(THINK_PATH."/ThinkPHP.php");
//实例化一个网站应用实??
App::run();
?>