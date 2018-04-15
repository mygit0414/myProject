<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo ($title); ?></title>
<meta name="keywords" content="<?php echo ($keywords); ?>">
<meta name="description" content="<?php echo ($page_description); ?>">
<link href="__APP____PUBLIC__/css/head.css" rel="stylesheet" type="text/css" />
<link href="__APP____PUBLIC__/css/index.css" rel="stylesheet" type="text/css" />
<link href="__APP____PUBLIC__/images/favicon.ico" type="image/ico" rel="shortcut icon">
<link href="__APP____PUBLIC__/js/p7ssm/css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__APP____PUBLIC__/js/jquery-1.4.4.js"></script>
<script type="text/javascript" src="__APP____PUBLIC__/js/common.js"></script>
<script type="text/javascript" src="__APP____PUBLIC__/js/p7ssm/js/show.js"></script>
<script language="JavaScript">
jQuery(function(){
	/*-------搜索框--------*/
	jQueryq=jQuery("#searchText");
	
	var defaultValue = '请输入楼盘名称';
	if(jQueryq.val() ==  defaultValue)jQueryq.css("color","#898989");
	jQueryq.focus(function(){
		if(jQuery(this).val()==defaultValue)jQuery(this).val("");
		jQuery(this).css("color","");
	}).blur(function(){
		if(!jQuery(this).val()||jQuery(this).val()==defaultValue){
jQuery(this).css("color","#898989");
jQuery(this).val(defaultValue);
		}
	})
	jQuery(document).ready(function(){
		jQuery("#search-form").submit(function(){
			var val = jQuery("input[name='keyWord']").val();
			jQuery("input[name='keyWord']").attr("value", val.trim());
			if (jQuery("input[name='keyWord']").val() == '请输入楼盘名称') {
				jQuery("input[name='keyWord']").attr("value", '');
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

	var longitude = <?php echo ($product["longitude"]); ?>;//默认显示经度
	var latitude = <?php echo ($product["latitude"]); ?>;//默认显示纬度
	var mapTitle = "<?php echo ($product["productName"]); ?>";//地图层显示的文字

	function initialize() {
		var map = new BMap.Map("container");          // 创建Map实例
		var point = new BMap.Point(longitude,latitude);  // 创建点坐标
		map.centerAndZoom(point,15);                  // 初始化地图,设置中心点坐标和地图级别。
		map.enableScrollWheelZoom();                  // 启用滚轮放大缩小。
		map.enableKeyboard(); 
		var marker = new BMap.Marker(point);        // 创建标注  
		map.addOverlay(marker);                     // 启用键盘操作。
		var opts = {  
		 width : 200,     // 信息窗口宽度  
		 height: 10,     // 信息窗口高度(最小)  
		 title : mapTitle  // 信息窗口标题  
		}  
		var infoWindow = new BMap.InfoWindow("", opts);  // 创建信息窗口对象  
		map.openInfoWindow(infoWindow, map.getCenter());      // 打开信息窗口  
	}
	
	function loadScript() {
		var script = document.createElement("script");
		script.src = "http://api.map.baidu.com/api?v=1.2&callback=initialize";
		document.body.appendChild(script);
	}

	
</script>

</head>
<body  onLoad="loadScript();">
	
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
<!-- menu_bar end-->
	<?php if(($product['type'])  ==  "1"): ?><script>
			currentMenu("new");
		</script><?php endif; ?>
	
	<?php if(($product['type'])  ==  "2"): ?><script>
			currentMenu("second");
		</script><?php endif; ?>
	
	<div class="search">
		<form action="__APP__/house/search" id="search-form">
				<input type="hidden" name="type" value="2"/>
				

				<div class="select-box">
					<input type="hidden" value="" name="dist" />
					<span>区域不限</span>
					<ul>
						<li val="">区域不限</li>
						<?php if(is_array($distList)): $i = 0; $__LIST__ = $distList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dist): ++$i;$mod = ($i % 2 )?><li val="<?php echo ($dist["id"]); ?>" ><?php echo ($dist["name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				
				<div class="select-box">
					<input type="hidden" value="" name="area" />
					<span>区域不限</span>
					<ul>
						<li val="">价格不限</li>
						<?php if(is_array($priceArr)): $i = 0; $__LIST__ = $priceArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$price): ++$i;$mod = ($i % 2 )?><li val="<?php echo ($price); ?>" ><?php echo ($key); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<div class="select-box">
					<input type="hidden" value="" name="houseType" />
					<span>区域不限</span>
					<ul>
						<li val="">房型不限</li>
						<?php if(is_array($houseTypeArr)): $i = 0; $__LIST__ = $houseTypeArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$houseTypeAr): ++$i;$mod = ($i % 2 )?><li val="<?php echo ($houseTypeAr); ?>" ><?php echo ($key); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<div class="select-box">
					<input type="hidden" value="" name="useArea" />
					<span>区域不限</span>
					<ul>
						<li val="">面积不限</li>
						<?php if(is_array($areaArr)): $i = 0; $__LIST__ = $areaArr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$area): ++$i;$mod = ($i % 2 )?><li val="<?php echo ($area); ?>" ><?php echo ($key); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<input type="text" name="keyWord" id="searchText" value="请输入楼盘名称">
				<input class="btn" type="submit" value="搜  索" >
			</form>
			
		</div>
		<!-- menu_bar end-->
		
	<?php if(!empty($noteList)): ?><div class="news">
		<marquee direction="left" scrollamount=3　 onMouseOver=this.stop() onMouseOut=this.start()>
		
		<?php if(is_array($noteList)): foreach($noteList as $key=>$note): ?><span><a href="<?php echo ($note["link"]); ?>" target="_blank"><?php echo ($note["title"]); ?></a></span><?php endforeach; endif; ?>
		</marquee>
	 
</div><?php endif; ?>

<!-- 首页没有导航，设置距离顶部10像素，如果有滚动新闻的话就不要这个DIV -->
<?php if($indexPage == 'index' ): ?><div class="mt10"></div><?php endif; ?>

	
	
	<div class="breadCrumb">
		<a href="__APP__/"><?php echo ($com["abbreviation"]); ?></a> &gt; 
		<?php if(($product['type'])  ==  "2"): ?><a href="__APP__/house/search?type=2" ><?php echo ($com["cityName"]); ?>二手房</a> &gt;
		<a href=""><?php echo ($product["productName"]); ?></a><?php endif; ?>
		
		<?php if(($product['type'])  ==  "1"): ?><a href="__APP__/house/search?type=1"><?php echo ($com["cityName"]); ?>新房</a> &gt;
		<a href="" ><?php echo ($product["productName"]); ?></a><?php endif; ?>
	</div>		
	<div id="index_content">
		<div id="contentL" class="fl">
			<div class="h-box " >
					<a id="prop_title" name="prop_title"></a>
					<h1 class="prop_title"><?php echo ($product["productName"]); ?></h1>
					<div class="prop_basic">
						<div class="prop_pic">
							<div id="p7ssm">
      <div id="p7ssm_cf">&nbsp;</div>
     <div id="p7ssm_loading"><img src="__APP__" /></div>
      <table id="p7ssm_fstbl" border="0" cellpadding="0" cellspacing="0" summary="Fullsize Image">
        <tr>
          <td><div id="p7ssm_fullsize">
              <div id="p7ssm_fsc">
                <div id="p7ssm_fsw">
                  <div id="p7ssm_fsimg"><a href="javascript:;" id="p7ssm_fslink">
                  <?php if($picNum == 0): ?><img src="__APP____PUBLIC__/js/p7ssm/images/nopic.jpeg" alt="<?php echo ($com["abbreviation"]); ?>" name="p7ssm_im" width="250" height="245" border="0" id="p7ssm_im" />
                  <?php else: ?>
                  	<img src="__APP____PUBLIC__/images/loading.gif" alt="<?php echo ($com["abbreviation"]); ?>" name="p7ssm_im" width="250" height="245" border="0" id="p7ssm_im" /><?php endif; ?>
                  </a></div>
                  <div id="p7ssm_description"></div>
                </div>
              </div>
            </div></td>
        </tr>
      </table>
      <div id="p7SSMwhmb">
        <div id="p7ssm_thumbs">
          <div id="p7SSMwp_1">
            <div class="p7ssm_thumb_section">
              <ul><!-- 修改内容开始 -->

				<?php if(is_array($picList)): foreach($picList as $i=>$pic): ?><?php if($i < 4): ?><li style="margin-left:2px;"><a href="__APP__<?php echo ($pic["bigPicUrl"]); ?>">
					<img src="__APP__<?php echo ($pic["thumb"]); ?>" alt="<?php echo ($pic["title"]); ?>" width="250" height="245" /></a>
	                  <div class="p7ssm_lk"></div>
	                  <div class="p7ssm_fd"><?php echo ($pic["title"]); ?></div>
	                </li><?php endif; ?><?php endforeach; endif; ?>
                
              <!-- 修改内容结束 --></ul>
              <br class="p7ssm_clearThumbs" />
            </div>
          </div>
        </div>
      </div>
      
     <div id="picMoreLink"><a href="#pic">共有<?php echo ($picNum); ?>张房源图片，查看全部>>></a></div>
      
      <div id="p7ssm_toolbar">
        <div class="p7ssm_sectionTrigger"><a id="p7SSMtp_1" href="#">New Image Set</a></div>
        <div id="p7ssm_dragbar" title="Move"><span>Move</span></div>
        <div id="p7ssm_preview">   
          <table summary="Thumbnail Preview">
            <tr>
              <td><img src="__APP____PUBLIC__/js/p7ssm/images/biaozhi.gif" alt="<?php echo ($com["abbreviation"]); ?>" /></td>
            </tr>
          </table>
        </div>
        <div id="p7ssm_tools">
          <table border="0" cellpadding="0" cellspacing="0" summary="Slideshow Toolbar">
            <tr>
              <td><div id="p7ssm_nav_wrapper"><a id="p7SSMtnav" href="#" title="Menu"><em>Navigate</em></a>
                  <div id="p7SSMwnav">
                    <div id="p7ssm_navList">
                      <ul>
                        <li></li>
                      </ul>
                    </div>
                  </div>
                </div></td>
              <td><a href="#" title="Hide or Show Thumbnails" id="p7SSMthmb"><em>Hide Thumbs</em></a></td>
              <td><a href="#" id="p7ssm_first" title="First Image"><em>First</em></a></td>
              <td><a href="#" id="p7ssm_prev" title="Previous Image"><em>Previous</em></a></td>
              <td><a href="#" id="p7ssm_pp" class="p7ssm_pause" title="Pause"><em>Pause</em></a></td>
              <td><a href="#" id="p7ssm_next" title="Next Image"><em>Next</em></a></td>
              <td><a href="#" id="p7ssm_last" title="Last Image"><em>Last</em></a></td>
              <td><div id="p7ssm_slidechannel">
                  <div id="p7ssm_slider"><a href="#" id="p7ssm_slidebar" title="Speed:"><em>Set Speed</em></a></div>
                                  </div></td>
               </tr>
          </table>
        </div>
      </div>
      
<!--[if IE 7]>
<style>
#p7ssm, #p7ssm div {zoom: 1;}
</style><![endif]-->
<!--[if IE 6]><style>
#p7ssm a, #p7ssm, #p7ssm div, #p7ssm_thumb_wrapper {zoom: 1;}
.p7ssm_thumb_section {padding-right: 0; padding-left: 0;}
.p7ssm_thumb_section a {float: left;}
</style><![endif]-->
<!--[if IE 5]><style>
#p7ssm {}
.p7ssm_sectionTrigger {text-align: left;}
#p7ssm_navList li {float: left; clear:both; width: 100%;}
#p7ssm, #p7ssm_w1, #p7ssm_w2, #p7ssm_description, #p7ssm_preview,
#p7ssm_navList a, .p7ssm_sectionTrigger a, #p7ssm_thumbs,
.p7ssm_thumb_section, #p7ssm_fsw {height: 1%;}
.p7ssm_thumb_section {padding: 0;}
</style><![endif]-->
<!--[if IE 5.5000]><style>
#p7ssm, #p7ssm_w1, #p7ssm_w2 {zoom: 1;}
</style><![endif]-->
<script type="text/javascript">
<!--
P7_SSMinit(1,1,1,1,0,1,1,1,5);
//-->
</script>
</div>
						</div>
						<div class="prop_basic_left">
							<p><strong>售价：</strong><em><?php echo (number_format($product["totalPrice"],0,".","")); ?></em>万元</p>
							<p><strong>房型：</strong><?php echo ($view_houseType); ?>
							<p><strong>单价：</strong><?php echo (number_format($product["unitPrice"],0,".","")); ?>元/平米</p>
							<p><strong>产证面积：</strong><?php echo (number_format($product["area"],2,".","")); ?>平米</p>
							<p><strong>使用面积：</strong><?php echo (number_format($product["useArea"],2,".","")); ?>平米</p>
							<p><strong>房龄：</strong><?php echo ($product["houseAge"]); ?>年</p>
						</div>
						<div class="prop_basic_right">
							<p><strong>楼层</strong>：<?php echo ($product["floor"]); ?></p>
							<p><strong>朝向：</strong><?php echo ($view_direction); ?></p>
							<p><strong>装修：</strong><?php echo ($view_decoration); ?></p>
							
							<p>发布时间：<?php echo ($product["date"]); ?></p>
						</div>
						<div class="areaInfo">
							<p><strong>地址：</strong><?php echo ($product["address"]); ?></p>
							<p><strong>小区：</strong><?php echo ($product["communityName"]); ?>&nbsp;<span id="showMap"><a href="#map">查看地图</a></span></p>
							<div class="prop_tel"><h3><?php echo ($agent["mobile"]); ?> <?php echo ($agent["nickName"]); ?></h3></div>
						</div>
						
						
						<div id="filter">
							<ul class="tabbar">
							<li class="selected"><a href="#prop_title">房源介绍</a></li>
							</ul>
						</div>
						
						<div class="prop_desc">
							<strong class="prop_rec"><?php echo ($product["recommendation"]); ?></strong>
							<?php echo ($product["description"]); ?>
							
							<span id="pic"><br/></span>
							<p>
								<center>
									
									<?php if(is_array($picList)): foreach($picList as $key=>$pic): ?><img src="__APP__<?php echo ($pic["bigPicUrl"]); ?>" alt="<?php echo ($pic["title"]); ?>" /><br>
										<p class="imgfont"><?php echo ($pic["title"]); ?></p><br><?php endforeach; endif; ?>
									
								</center>
							</p>
						</div>
						
						<p id="map"><br/></p>
						<div id="container"  class="prop_map">
							
						</div>

						<div class="prop_tel"><h3><?php echo ($agent["mobile"]); ?> <?php echo ($agent["nickName"]); ?></h3></div>
						
						<div class="house-around">
						<dl>
							
							<?php if(!empty($product["subway"])): ?><dd><label>地铁：</label><?php echo ($product["subway"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["bus"])): ?><dd><label>公交：</label><?php echo ($product["bus"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["transportHub"])): ?><dd><label>临近交通枢纽：</label><?php echo ($product["transportHub"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["school"])): ?><dd><label>学校：</label><?php echo ($product["school"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["kindergarten"])): ?><dd><label>幼儿园：</label><?php echo ($product["kindergarten"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["shopping"])): ?><dd><label>商场：</label><?php echo ($product["shopping"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["hospital"])): ?><dd><label>医院：</label><?php echo ($product["hospital"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["bank"])): ?><dd><label>银行：</label><?php echo ($product["bank"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["post"])): ?><dd><label>邮局：</label><?php echo ($product["post"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["dining"])): ?><dd><label>餐饮：</label><?php echo ($product["dining"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["businessCenter"])): ?><dd><label>临近商业中心：</label><?php echo ($product["businessCenter"]); ?></dd><?php endif; ?>
							<?php if(!empty($product["ortherFacility"])): ?><dd><label>其它：</label><?php echo ($product["ortherFacility"]); ?></dd><?php endif; ?>
						</dl>
						</div>

					<div class="clear"></div>
					</div>
					
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