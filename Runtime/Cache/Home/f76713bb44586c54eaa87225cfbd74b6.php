<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo ($com["abbreviation"]); ?> - <?php echo ($com["cityName"]); ?>二手房网,<?php echo ($com["cityName"]); ?>新楼盘,<?php echo ($com["cityName"]); ?>租房</title>
<meta name="keywords" content="<?php echo ($com["cityName"]); ?>二手房网,<?php echo ($com["cityName"]); ?>二手房,<?php echo ($com["cityName"]); ?>新楼盘,<?php echo ($com["cityName"]); ?>新房,<?php echo ($com["cityName"]); ?>租房">
<meta name="description" content="<?php echo ($com["abbreviation"]); ?>是<?php echo ($com["cityName"]); ?>一家专业房地产公司，业务范围：<?php echo ($com["cityName"]); ?>二手房、<?php echo ($com["cityName"]); ?>新楼盘、<?php echo ($com["cityName"]); ?>房屋出租等，更多<?php echo ($com["cityName"]); ?>二手房信息，请上<?php echo ($com["cityName"]); ?>二手房网！房源热线：<?php echo ($com["tel"]); ?>">
<link href="__APP____PUBLIC__/css/head.css" rel="stylesheet" type="text/css" />
<link href="__APP____PUBLIC__/css/index.css" rel="stylesheet" type="text/css" />	
<link href="__APP____PUBLIC__/images/favicon.ico" type="image/ico" rel="shortcut icon">
<script type="text/javascript" src="__APP____PUBLIC__/js/jquery-1.4.4.js"></script>
<script type="text/javascript" src="__APP____PUBLIC__/js/common.js"></script>
<script language="JavaScript">
$(function(){
	/*-------搜索框--------*/
	jQueryq=$("#searchText");
	
	var defaultValue = '请输入楼盘名称';
	if(jQueryq.val() ==  defaultValue)jQueryq.css("color","#898989");
	jQueryq.focus(function(){
		if($(this).val()==defaultValue)$(this).val("");
		$(this).css("color","");
	}).blur(function(){
		if(!$(this).val()||$(this).val()==defaultValue){
$(this).css("color","#898989");
$(this).val(defaultValue);
		}
	})
	$(document).ready(function(){
		$("#search-form").submit(function(){
if ($("input[name='name']").val() == '请输入楼盘名称') {
	$("input[name='name']").attr("value", '');
}
		});
	});
	/*-----伪selet框--J_select("选择器","下拉框高度")----*/
	J_select(".select-box",420);
})
	var imgpath = 'images';
	var verifyhash = '94afdd2b';
	var modeimg = 'mode/house/images';
	var modeBase = '';
	var winduid = '';
	var windid	= '';
	var groupid	= 'guest';
	var cateid	= 'index';
	var mode = 'house';
</script>

</head>
<body>
	<div class="container">
	
	
	<div id="headNav">
	<div id="hnav_content">
		<span><?php echo ($com["headTip"]); ?></span><?php if(!empty($com["tel"])): ?><span>欢迎拨打房源热线：</span><span class="tel"><?php echo ($com["tel"]); ?></span><?php endif; ?>
		
		<ul>
			<li> <a onClick="SetHomepage(window.location)" title="将<?php echo ($com["abbreviation"]); ?>网设为首页" href="javascript::void(0);">设为首页</a></li>
			<li><a onClick="AddFavorite(window.location,document.title)" title="加入收藏" href="javascript:void(0);">加入收藏夹</a></li>
		</ul>
	</div>
</div><!-- headNav end -->

<div id="head_box">
	<span id="logo"><a href="__APP__/"><img src="__APP__<?php echo ($com["logo"]); ?>" width="180" height="80" alt="<?php echo ($com["abbreviation"]); ?> - <?php echo ($com["cityName"]); ?>二手房,<?php echo ($com["cityName"]); ?>新楼盘,<?php echo ($com["cityName"]); ?>租房" /></a></span>
	<span id="address"><?php echo ($com["cityName"]); ?></span>
	<span id="ad"><a href="<?php echo ($banner["link"]); ?>" target="_blank"><img src="__APP__<?php echo ($banner["path"]); ?>" alt="<?php echo ($banner["name"]); ?>" width="680" height="80"/></a></span>
</div><!-- head_box end-->
	
	<div id="menu_bar">
		<div class="menu_barL fl"></div>
		<div class="menu_barR fr"></div>
		<div class="menu_bar">
			<ul class="mnav_ul">
			    <li id="index"><a href="__APP__/">首页 </a></li>
			    <li id="second"><a href="__APP__/house/search?type=2">二手房</a></li>
			    <li id="new"><a href="__APP__/house/search?type=1">新房</a></li>
			    <li id="rent"><a href="__APP__/house/rentHouse">租房 </a></li>
			    <li id="shangpu"><a href="__APP__/shangpu/index">商铺租售</a></li>
			    <li id="tuangou"><a href="__APP__/tuangou/index">一手楼团购</a></li>
			    <li id="dipi"><a href="__APP__/dichan/chuzu">厂房/仓库/地皮</a></li>
			    <!-- <li id="dipi"><a href="landRental.html">地皮转让</a></li>
			    <li id="wuye"><a href="index.php?m=house&q=broker">物业代理</a></li>
			    <li id="pingu"><a href="index.php?m=house&q=broker">房屋评估咨询</a></li>
			    <li id="daiban"><a href="index.php?m=house&q=broker">代办房地产契证手续</a></li>
			     -->
			</ul>
		</div>
	</div><!-- menu_bar end-->

	<script>
		currentMenu("index");
	</script>
	<div class="search">
			<form action="__APP__/house/search" target="_blank">
				<input type="hidden" name="type" value="2"/>
				<div class="select-box">
					<input type="hidden" value="" name="dist" />
					<span>区域不限</span>
					<ul>
						<li val="">区域不限</li>
						<?php if(is_array($distList)): $i = 0; $__LIST__ = $distList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dist): ++$i;$mod = ($i % 2 )?><li val="<?php echo ($dist["id"]); ?>"><?php echo ($dist["name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				
				<div class="select-box">
					<input type="hidden" value="" name="price" />
					<span>价格不限</span>
					<ul><li val="">价格不限</li>
						<?php if(is_array($priceArr)): foreach($priceArr as $key=>$price): ?><li val="<?php echo ($price); ?>"><?php echo ($key); ?></li><?php endforeach; endif; ?>
					</ul>
				</div>
				<div class="select-box">
					<input type="hidden" value="" name="houseType" />
					<span>房型不限</span>
					<ul><li val="">房型不限</li>
						<?php if(is_array($houseTypeArr)): foreach($houseTypeArr as $key=>$htype): ?><li val="<?php echo ($htype); ?>"><?php echo ($key); ?></li><?php endforeach; endif; ?>
					</ul>
				</div>
				<div class="select-box">
					<input type="hidden" value="" name="useArea" />
					<span>面积不限</span>
					<ul><li val="">面积不限</li>
						<?php if(is_array($areaArr)): foreach($areaArr as $key=>$area): ?><li val="<?php echo ($area); ?>"><?php echo ($key); ?></li><?php endforeach; endif; ?>						
					</ul>
				</div>
				<input type="text" name="keyWord" id="searchText" value="请输入楼盘名称">
				<input class="btn" type="submit" onclick="if(getObj('searchText').value == '请输入楼盘名称') getObj('searchText').value=''"  value="搜  索" id="searchBt">
			</form>
			
		</div>
	
	<?php if(!empty($noteList)): ?><div class="news">
		<marquee direction="left" scrollamount=3　 onMouseOver=this.stop() onMouseOut=this.start()>
		
		<?php if(is_array($noteList)): foreach($noteList as $key=>$note): ?><span><a href="<?php echo ($note["link"]); ?>" target="_blank"><?php echo ($note["title"]); ?></a></span><?php endforeach; endif; ?>
		</marquee>
	 
</div><?php endif; ?>

<!-- 首页没有导航，设置距离顶部10像素，如果有滚动新闻的话就不要这个DIV -->
<?php if($indexPage == 'index' ): ?><div class="mt10"></div><?php endif; ?>

	
	<div id="index_content">
		<div id="contentL" class="fl">
			<div class="h-box">
				<div class="ht"><h2><?php echo ($com["cityName"]); ?>新房</h2><span class="more"><a href="__APP__/house/search?type=1" target="_blank">更多<?php echo ($com["cityName"]); ?>新房>></a></span></div>
				
				
				<?php if(is_array($houseList)): foreach($houseList as $key=>$house): ?><div class="ht-box fl" title="<?php echo ($house["productName"]); ?>">
					<div class="pic fl"><a href="__APP__/house/view?id=<?php echo ($house["id"]); ?>" target="_blank">
							<?php if($house["picture"] == ''): ?><img src="__APP__<?php echo ($com["proDefaultPic"]); ?>" alt="<?php echo ($house["productName"]); ?>" width="144" height="130" />
							<?php else: ?> <img src="__APP__<?php echo ($house["picture"]); ?>" alt="<?php echo ($house["productName"]); ?>" width="144" height="130" /><?php endif; ?>
						</a></div>
					<div class="sx fl">
						<p><h3><strong><a href="__APP__/house/view?id=<?php echo ($house["id"]); ?>" target="_blank" title="<?php echo ($house["productName"]); ?>"><?php echo (msubstr($house["productName"],0,22,'utf-8',false)); ?></a></strong></h3></p>
						<p><strong>户型：</strong>
							<?php if(is_array($houseTypeArr)): foreach($houseTypeArr as $key=>$htype): ?><?php if($house["houseType"] == $htype): ?><?php echo ($key); ?><?php endif; ?><?php endforeach; endif; ?>
				        </p>
						<p><strong>面积：</strong><?php echo (number_format($house["useArea"],0)); ?>㎡</p>
						<p><strong>价格：</strong><strong class="red font13"><?php echo (number_format($house["totalPrice"],0)); ?>万</strong> <span><?php echo (number_format($house["unitPrice"],0,',','')); ?>/每平米</span></p>
						<!-- <p><strong>开发商：</strong><?php echo (msubstr($house["develop"],0,24,'utf-8',false)); ?></p> -->
						<p><strong>楼盘地址：</strong><?php echo (msubstr($house["address"],0,23,'utf-8',false)); ?></p>
					</div>
					<div class="clear"></div>
					<div class="tjsm"><strong class="fl">推荐理由：</strong><?php echo (msubstr($house["recommendation"],0,40,'utf-8',false)); ?></div>
				</div><?php endforeach; endif; ?>
				
				
				<div class="clear"></div>
			</div>
			
			<!-- <div class="h-box"><a href="houseDetails.html" target="_blank"><img src="__APP__images/test/44994659_07_112634.jpg" width=700 height=80 /></a></div> -->
			
			<div class="h-box ">
				<div class="ht"><h2><?php echo ($com["cityName"]); ?>二手房</h2><span class="more"><a href="__APP__/house/search?type=2" target="_blank">更多<?php echo ($com["cityName"]); ?>二手房>></a></span></div>
				
				<?php if(is_array($secondHouseList)): foreach($secondHouseList as $key=>$secondhouse): ?><div class="ht-box fl">
					<div class="pic fl"><a href="__APP__/house/view?id=<?php echo ($secondhouse["id"]); ?>" target="_blank">
						<?php if($secondhouse["picture"] == ''): ?><img src="__APP__<?php echo ($com["proDefaultPic"]); ?>" alt="<?php echo ($secondhouse["productName"]); ?>" width="144" height="130" />
						<?php else: ?> <img src="__APP__<?php echo ($secondhouse["picture"]); ?>" alt="<?php echo ($secondhouse["productName"]); ?>" width="144" height="130" /><?php endif; ?>
					</a></div>
					<div class="sx fl">
						<p><h3><strong><a href="__APP__/house/view?id=<?php echo ($secondhouse["id"]); ?>" title="<?php echo ($secondhouse["productName"]); ?>" target="_blank"><?php echo (msubstr($secondhouse["productName"],0,22,'utf-8',false)); ?></a></strong></h3></p>
						<p><strong>户型：</strong>
							<?php if(is_array($houseTypeArr)): foreach($houseTypeArr as $key=>$htype): ?><?php if($secondhouse["houseType"] == $htype): ?><?php echo ($key); ?><?php endif; ?><?php endforeach; endif; ?></p>
						<p><strong>面积：</strong><?php echo (number_format($secondhouse["useArea"],0)); ?>㎡</p>
						<p><strong>价格：</strong><strong class="red font13"><?php echo (number_format($secondhouse["totalPrice"],0)); ?>万</strong> <span><?php echo (number_format($secondhouse["unitPrice"],0,',','')); ?>/每平米</span></p>
						<!-- <p><strong>开发商：</strong><?php echo (msubstr($secondhouse["develop"],0,24,'utf-8',false)); ?></p> -->
						<p><strong>楼盘地址：</strong><?php echo (msubstr($secondhouse["address"],0,23,'utf-8',false)); ?></p>
					</div>
					<div class="clear"></div>
					<div class="tjsm"><strong>推荐理由：</strong><?php echo (msubstr($secondhouse["recommendation"],0,40,'utf-8',false)); ?></div>
				</div><?php endforeach; endif; ?>
				
				<div class="clear"></div>
			</div>
			
			<div class="h-box">
				<div class="ht"><h2><?php echo ($com["cityName"]); ?>房屋出租</h2><span class="more"><a href="__APP__/house/rentHouse" target="_blank">更多<?php echo ($com["cityName"]); ?>出租>></a></span></div>
				
				<?php if(is_array($rentHouseList)): foreach($rentHouseList as $key=>$rent): ?><div class="cz-box bgF" >
					<div class="pic fl">
						<?php if($rent["picture"] == ''): ?><img src="__APP__<?php echo ($com["proDefaultPic"]); ?>" alt="<?php echo ($rent["productName"]); ?>" width="110" height="90" />
						<?php else: ?> <img src="__APP__<?php echo ($rent["picture"]); ?>" alt="<?php echo ($rent["productName"]); ?>" width="110" height="90" /><?php endif; ?>	
					</div>
					<div class="info fl">
						<p class="title"><a href="__APP__/house/view?id=<?php echo ($rent["id"]); ?>" target="_blank"><?php echo (msubstr($rent["productName"],0,28,'utf-8',false)); ?></a></p>
						<p class="area"><?php echo (msubstr($rent["address"],0,23,'utf-8',false)); ?> </p>
						<p class="desc"><?php echo (msubstr($rent["recommendation"],0,40,'utf-8',false)); ?></p>
						<p class="contact"><?php echo ($rent["nickName"]); ?> <?php echo ($rent["mobile"]); ?> </p>
					</div>
					<div class="price p1 fl"><strong><?php echo (number_format($rent["rent"],0,',','')); ?></strong><span class="moth">元/月</span></div> 
				</div><?php endforeach; endif; ?>
				
			</div>
			
			
			<div class="h-box">
				<div class="ht"><h2><?php echo ($com["cityName"]); ?>商铺</h2><span class="more"><a href="__APP__/shangpu/index" target="_blank" title="<?php echo ($com["cityName"]); ?>商铺">更多<?php echo ($com["cityName"]); ?>商铺>></a></span></div>
				
				<?php if(is_array($shangpuList)): foreach($shangpuList as $key=>$shangpu): ?><div class="cz-box bgF" >
					<div class="pic fl">
						<?php if($shangpu["picture"] == ''): ?><img src="__APP__<?php echo ($com["proDefaultPic"]); ?>" alt="<?php echo ($shangpu["productName"]); ?>" width="110" height="90" />
						<?php else: ?> <img src="__APP__<?php echo ($shangpu["picture"]); ?>" alt="<?php echo ($shangpu["productName"]); ?>" width="110" height="90" /><?php endif; ?>	
					</div>
					<div class="info info-a fl">
						<p class="title"><a href="__APP__/shangpu/<?php echo ($shangpu["id"]); ?>.html" target="_blank"><?php echo (msubstr($shangpu["productName"],0,40,'utf-8',false)); ?></a></p>
						<p class="area"><?php echo (msubstr($shangpu["address"],0,40,'utf-8',false)); ?> </p>
						<p class="desc"><?php echo (msubstr($shangpu["recommendation"],0,40,'utf-8',false)); ?></p>
						<p class="contact"><?php echo ($shangpu["nickName"]); ?> <?php echo ($shangpu["mobile"]); ?> </p>
					</div>
				</div><?php endforeach; endif; ?>
				
			</div>
			
		</div>
		
		<div id="contentR">
			<?php if($tuanPage == 1): ?><div class="ht"><h3>楼盘团购说明</h3></div>
				<div class="cr_div profile color000 clear"><?php echo ($com["tuangouDesc"]); ?></div>
			<?php else: ?>
				<div class="ht"><?php if($indexPage == 'index' ): ?><h1><?php echo ($com["abbreviation"]); ?></h1><?php else: ?><h3><?php echo ($com["abbreviation"]); ?></h3><?php endif; ?><span>简介</span></div>
				<div class="cr_div text-indent2 profile colBB3 clear"><strong><?php echo ($com["introduction"]); ?></strong></div><?php endif; ?>
			
			<div class="ht rbt"><h3>巨丰置业专家</h3></div>
			<div>
				<ul class="house_expert">
					
					<?php if(is_array($agentList)): foreach($agentList as $key=>$agent): ?><li>
						<div class="house_expert_left">
							<?php if($agent["headPic"] == ''): ?><img src="__APP__/Public/js/p7ssm/images/nopic.jpeg" alt="<?php echo ($agent["nickName"]); ?>：<?php echo ($agent["introduction"]); ?>" width="110" height="115" />
							<?php else: ?> <img src="__APP__<?php echo ($agent["headPic"]); ?>" alt="<?php echo ($agent["nickName"]); ?>：<?php echo ($agent["introduction"]); ?>" width="110" height="115" /><?php endif; ?>	
						</div>
						<div class="house_expert_right">
							<div class="text"><b><?php echo ($agent["nickName"]); ?>：</b><?php echo ($agent["introduction"]); ?></div>
							<p class="qq">QQ：<img src="http://wpa.qq.com/pa?p=1:<?php echo ($agent["qq"]); ?>:1" alt="点击咨询" width="74" height="23" style="CURSOR: pointer;" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($agent["qq"]); ?>&site=qq&menu=yes', '_blank', 'height=502, width=644,toolbar=no,scrollbars=no,menubar=no,status=no');"  border="0"  ></p>
							<p>手机：<?php echo ($agent["mobile"]); ?></p>
						</div>
						<div class="clear"></div>
					</li>
					<li class="grayline clear"></li><?php endforeach; endif; ?>
				</ul>
			</div>
			
			<div class="ht rbt"><h3><?php echo ($com["cityName"]); ?>房产资讯</h3></div>
			
			<div>
				
				<ul class="articlelist">
					<?php if(is_array($newsList)): foreach($newsList as $key=>$news): ?><li><a href="__APP__/news/<?php echo ($news["id"]); ?>.html" target="_blank"><?php echo ($news["title"]); ?></a></li><?php endforeach; endif; ?>
				</ul>
			</div>
			
		</div>
		
	</div><!-- index_content end -->
	
	<div class="clear"></div>
	<div id="footer">
	<div id="link">
	友情链接：<span><a href="http://www.baidu.com" target="_blank">百度</a> </span>
	</div>
	<div id="siteinfo">
		<span><a href="__APP__/Index/about" target="_blank" rel="nofollow">关于巨丰</a> </span>
		<span><a href="__APP__#" rel="nofollow">版权声明 </a> </span>
		<span><a href="__APP__#" rel="nofollow">免责声明 </a> </span>
		<span><a href="__APP__#" rel="nofollow">联系我们 </a> </span>
		<span><a href="__APP__/sitemap.html" target="_blank">网站地图 </a> </span>
		<span>
			<script src="http://s84.cnzz.com/stat.php?id=4633883&web_id=4633883&show=pic" language="JavaScript"></script>
		</span>
	</div>
</div>

<!-- Baidu Button BEGIN -->
<script type="text/javascript" id="bdshare_js" data="type=slide&amp;img=6&amp;pos=right&amp;uid=6507792" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
</script>
<!-- Baidu Button END -->

<!-- 将此代码放在适当的位置，建议在body结束前 -->
<script id="bdlike_shell"></script>
<script>
var bdShare_config = {
	"type":"medium",
	"color":"blue",
	"uid":"6507792"
};
document.getElementById("bdlike_shell").src="http://bdimg.share.baidu.com/static/js/like_shell.js?t=" + Math.ceil(new Date()/3600000);
</script><!-- menu_bar end-->
	
	</div>
</body>
</html>