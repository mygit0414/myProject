<?php
return array(
	//'配置项'=>'配置值'
	'APP_GROUP_LIST'        => 'Home,Admin',      // 项目分组设定,多个组之间用逗号分隔,例如'Home,Admin'
	'DEFAULT_GROUP'         => 'Home',  // 默认分组
	
	'APP_DEBUG'				=> true,	// 是否开启调试模式
	
	/* 数据库设置 */
    'DB_TYPE'               => 'mysql',     // 数据库类型
	'DB_HOST'               => 'localhost', // 服务器地址
	'DB_NAME'               => 'jfhome',          // 数据库名aa5si7t27a_jf2
	'DB_USER'               => 'root',      // 用户名
	'DB_PWD'                => '',          // 密码
	'DB_PORT'               => 3306,        // 端口
	'DB_PREFIX'             => '',          // 数据库表前缀
	'DB_SUFFIX'             => '',          // 数据库表后缀
    'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       => true,        // 启用字段缓存
    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        => 0,           // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        => false,       // 数据库读写是否分离 主从式有效
	
	'URL_MODEL'             => 2,         //URL重定义模式
	'URL_ROUTER_ON'	        => true,        //使用 URL 路由功能
	'URL_CASE_INSENSITIVE'  => true,       //忽略大小写
	
    'TMPL_ACTION_ERROR'     => '/Tpl/default/Home/error.html',
    'ERROR_PAGE'            =>'/Public/error/error.html', // 定义错误跳转页面URL地址
	
);
?>