<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>后台管理</title>
	<link href="/Public/css/admin/style.css" rel="stylesheet" type="text/css" />
	<link href="/Public/css/validator.css" rel="stylesheet" type="text/css" />
	<script src="/Public/js/jquery-1.4.4.min.js" type="text/javascript" charset="UTF-8"></script>
	<script src="/Public/admin/js/formValidator-4.1.1.min.js" type="text/javascript" charset="UTF-8"></script>
	<script type="text/javascript" src="/Public/admin/js/common.js"></script>
</head>

<body>
	
		<div id="headNav">
	<div id="hnav_content">
		
		<span id="login">欢迎您：<?php echo ($_SESSION['loginName']); ?> [<a href="__APP__/Admin/Login/loginOut">退出</a>]</span>
		<div class="clear"></div>	
	</div>
</div><!-- headNav end-->

		
		<div id="wrapper">
			<div id="nav_trail"><a href="#">后台管理</a> 管理首页</div>
			<div id="content">
			
				<!-- 左边菜单 -->
				<div id="left_area" class="columnl">
	<div id="leftmenu-top">
		<h2>后台管理</h2>
	</div>
	
	<div class="leftmenu">
		<ul>
			<li class="leftmenud" id="m_index"><a href="<?php echo U('Admin-Index/show');?>">管理首页</a></li>
		
			<li class="leftmenubg"></li>
			<li class="leftmenudn">地产管理</li>
			<li class="leftmenud" id="house"><a href="<?php echo U('Admin-house/index');?>">房源管理</a></li>
			<li class="leftmenud" id="rent"><a href="<?php echo U('Admin-rentHouse/index');?>">租房管理</a></li>
			<!-- 
			<li class="leftmenud" id="jituan_meg"><a href="http://admin.tianyaclub.com/supermanager/qiye_gruop.jsp">商铺租售管理</a></li>
			<li class="leftmenud" id="jituan_meg"><a href="http://admin.tianyaclub.com/supermanager/qiye_gruop.jsp">厂房管理</a></li>
			<li class="leftmenud" id="jituan_meg"><a href="http://admin.tianyaclub.com/supermanager/qiye_gruop.jsp">地皮管理</a></li>
			 -->
			 <!-- 
			<li class="leftmenubg"></li>
			<li class="leftmenudn">信息管理</li>
			<li class="leftmenud" id="product"><a href="http://admin.tianyaclub.com/productadminister/ProductAdminister/product.htm">物业代理</a></li>
			<li class="leftmenud" id="p_dingd"><a href="http://admin.tianyaclub.com/system/OrderManage/orderIndex.htm">房屋评估咨询</a></li>
			<li class="leftmenud" id="p_record"><a href="http://admin.tianyaclub.com/system/OrderManage/onlinePay.htm">代办房地产契证手续</a></li>
			-->
			<li class="leftmenud" id="p_dipi"><a href="__APP__/Admin/Dipi/index">地皮/厂房/仓库</a></li>
			<li class="leftmenud" id="p_tuangou"><a href="__APP__/Admin/Tuangou/index">团购</a></li>
			<li class="leftmenud" id="p_shangpu"><a href="__APP__/Admin/Shangpu/index">商铺管理</a></li>
			<li class="leftmenud" id="p_payID"><a href="__APP__/Admin/Ad/index">广告管理</a></li>
		 	
			<li class="leftmenubg"></li>
			<li class="leftmenudn">企业信息管理</li>
			<li class="leftmenud" id="m_cominfo"><a href="__APP__/Admin/Company/index">公司基本信息</a></li>
			<li class="leftmenud" id="m_agent"><a href="__APP__/Admin/Agent/index">置业专家</a></li>
			<!-- 
			<li class="leftmenud" id="tuangou"><a href="http://admin.tianyaclub.com/groupbuy/superGroupBuy/huodong_tuangou.htm">友情链接</a></li>
			 -->
			<li class="leftmenud" id="m_district"><a href="__APP__/Admin/District/index">行政区域管理</a></li>
			
			<li class="leftmenud" id="system"><a href="__APP__/Admin/Login/loginOut">退出</a></li>
		</ul>
	</div><!-- leftmenu end -->
</div><!-- left_area end -->
				<!-- 左边菜单 -->
				
				<script>
					menusel('m_index');
				</script>
				
				
				
				<div class="clear"></div>
			</div> <!-- content end-->
			<div id="footer"></div>
   		</div><!-- wrapper end-->
</body>
</html>