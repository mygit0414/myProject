/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.uiColor = '#d1d1d1';
	config.font_names='宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;'+ config.font_names;
	config.width = 730; //宽度   
	config.height = 300; //高度  
	
	config.skin='kama';
	
	
	//改变大小的最小高度 plugins/resize/plugin.js
	config.resize_minHeight = 250;
	 
	//改变大小的最小宽度 plugins/resize/plugin.js
	config.resize_minWidth = 630;  
	
	//改变大小的最大宽度 plugins/resize/plugin.js
	config.resize_maxWidth = 630;  
	config.forcePasteAsPlainText = true;
	//去掉语法拼写检查
	config.scayt_autoStartup = false;
	config.ImageBrowserURL='a.html';
	 
	//工具栏
	config.toolbar =
	[
	    ['Source','-','Bold','Italic','Underline','Strike'],
	    ['Cut', 'Copy', 'PasteText','-','NumberedList','BulletedList'], 
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['-', 'Find', 'Replace'],['Maximize'],
	    '/',
	    ['Font','FontSize'],['Link','Unlink','Anchor'],
	    ['TextColor','BGColor'],
	    ['Undo','Redo','-','Preview','picupload']
	
	];
};
