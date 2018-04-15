<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>后台管理</title>
	<link href="/Public/css/admin/style.css" rel="stylesheet" type="text/css" />
	<link href="/Public/css/validator.css" rel="stylesheet" type="text/css" />
	<script src="/Public/js/jquery-1.4.4.js" type="text/javascript" charset="UTF-8"></script>
	<script src="/Public/admin/js/formValidator-4.1.1.js" type="text/javascript" charset="UTF-8"></script>
	<script src="/Public/admin/js/formValidatorRegex.js" type="text/javascript" charset="UTF-8"></script>
	<script type="text/javascript" src="/Public/admin/js/common.js"></script>
	<!--在线编辑器引用-->
	<script type="text/javascript" src="/Public/js/ckeditor/ckeditor.js"></script>
	<!--在线编辑器引用-->
	
	<script>
		var longitude = <?php echo ($vo["longitude"]); ?>;//默认显示经度
		var latitude = <?php echo ($vo["latitude"]); ?>;//默认显示纬度
		var mapTitle = "<?php echo ($vo["productName"]); ?>";//地图层显示的文字

		function loadScript() {
			var script = document.createElement("script");
			script.src = "http://api.map.baidu.com/api?v=1.2&callback=initialize";
			document.body.appendChild(script);
		}

		function recommendationPic(id,obj){
			if(id==null || id==""){
				alert("设置推荐图错误！");return false;
			}
			
			if(obj==null){
				alert("设置推荐图错误！");return false;
			}

			var flag = "";
			if(obj.checked){
				flag = 1;
			}

			$.ajax({
			  url: '__URL__/recommendationPic',
			  data: {'id': id,'flag':flag},
			  success: function(data) {
			   	if(data!="success"){
				   	alert("推荐失败");
			   	}
			  }
			});
			
		}
		
		$(document).ready(function(){
			$.formValidator.initConfig({formID:"form1",autoTip:true,tidyMode:true,onError:function(msg){}});
			$("#productName").formValidator({onShow:"请输入房源名称",onFocus:"请输入房源名称",onCorrect:"输入正确"}).inputValidator({min:1,max:150,onError:"输入错误，请输入1~150个字!"});
			$("#totalPrice").formValidator({onShow:"请输入正数",onCorrect:"输入正确"}).regexValidator({regExp:"intege1",dataType:"enum",onError:"正数格式不正确"});
			$("#floor").formValidator({onShow:"请输入楼层",onFocus:"请输入楼层",onCorrect:"输入正确"}).inputValidator({min:1,max:10,onError:"输入错误，请输入1~10个字!"});
			$("#unitPrice").formValidator({onShow:"请输入每平米单价",onFocus:"请输入每平米单价",onCorrect:"输入正确"}).regexValidator({regExp:"intege1",dataType:"enum",onError:"单价只能输入正整数"});
			$("#area").formValidator({empty:true,onShow:"请输入正数",onFocus:"请输入正数",onCorrect:"输入正确"}).regexValidator({regExp:"intege1",dataType:"enum",onError:"正数格式不正确"});
			$("#propertyRightArea").formValidator({empty:true,onShow:"请输入正数",onFocus:"请输入正数",onCorrect:"输入正确"}).regexValidator({regExp:"intege1",dataType:"enum",onError:"正数格式不正确"});
			$("#useArea").formValidator({onShow:"请输入使用面积",onFocus:"请输入使用面积",onCorrect:"输入正确"}).regexValidator({regExp:"intege1",dataType:"enum",onError:"使用面积只能输入正整数"});
			$("#houseAge").formValidator({empty:true,onShow:"请输入正数",onFocus:"请输入正数",onCorrect:"输入正确"}).regexValidator({regExp:"intege1",dataType:"enum",onError:"正数格式不正确"});
			$("#districtID").formValidator({onShow:"选择物业所在区域",onFocus:"物业区域必须选择",onCorrect:"已选择"}).inputValidator({min:1,onError: "物业区域必须选择!"}).defaultPassed();
			//$("#type").formValidator({onShow:"选择物业类型",onFocus:"物业类型必须选择",onCorrect:"已选择"}).inputValidator({min:1,onError: "物业类型必须选择!"}).defaultPassed();
			$("#address").formValidator({empty:true,onShow:"请输入",onFocus:"请输入",onCorrect:"输入正确"}).inputValidator({min:1,max:150,onError:"输入错误，请输入1~150个字!"});
			$("#name").formValidator({onShow:"请输入房源名称",onFocus:"请输入房源名称",onCorrect:"输入正确"}).inputValidator({min:1,max:30,onError:"输入错误，请输入1~30个字!"});
			$("#communityName").formValidator({empty:true,onShow:"请输入",onFocus:"请输入",onCorrect:"输入正确"}).inputValidator({max:50,onError: "输入错误，最多可输入50个字!"})
			//$("#description").formValidator({onShow:"请输入房源介绍",onFocus:"请输入房源介绍",onCorrect:"输入正确"}).inputValidator({min:1,max:50,onError: "输入错误，请输入1~5000个字!"})
		});
		
	</script>
</head>

<body onLoad="loadScript();">
	
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
					menusel('house');
				</script>
				<div class="right_area">
					<div class="cbar">
			            
			              <ul>
			                <li><a href="__URL__/index">房源查询</a></li>
			    			<li class="cbar-tag-sel">编辑房源</a></li>
			              </ul>
			         </div><!-- cbar end -->
			         
			         <div class="cbox">
          
            <div class="ydbar">
      			<div class="info-title">编辑房源</div>
    		</div>	
       		
       		<form id="form1" name="form1" method="post" action="__URL__/update" enctype="multipart/form-data">
		       <input type="hidden" name="id" id="id" value="<?php echo ($vo["id"]); ?>" />
		       <input type="hidden" name="longitude" id="longitude" value="<?php echo ($vo["longitude"]); ?>" />
		       <input type="hidden" name="latitude" id="latitude" value="<?php echo ($vo["latitude"]); ?>" />
		    <table cellspacing="0" cellpadding="0" border="0" class="table-f">
		      <tbody>
		      <tr>
		        <td align="right" width="12%" class="formtdl">房源名称：</td>
		        <td align="left" colspan="3"><input type="text" id="productName" size="60" name="productName" value="<?php echo ($vo["productName"]); ?>" class="fl">
		        <div id="productNameTip" class="onShow tips" style="width:200px;">请输入产品名称</div></td>
		      </tr>
		          
		      <tr>
		        <td align="right" class="formtdl" width="12%">总价(万)：</td>
		        <td width="38%"><input type="text" id="totalPrice" size="10" name="totalPrice" value="<?php echo (number_format($vo["totalPrice"],0,',','')); ?>" class="fl"><div id="totalPriceTip" class="tips" style="width:140px;">请输入总价</div></td>
		        <td align="right" class="formtdl" width="12%">楼层：</td>
		        <td><input type="text" id="floor" size="10" name="floor" value="<?php echo ($vo["floor"]); ?>" class="fl"><div id="floorTip" class="tips" style="width:150px;">请输入楼层</div></td>
		       
		      </tr>
		      
		      <tr>
		        <td align="right" class="formtdl">房型：</td>
		        <td>
		        	<select name="houseType" id="houseType"  class="fl">
		        		<option value=-1 selected>请选择</option>
		        		 <?php if(is_array($houseTypeArr)): foreach($houseTypeArr as $key=>$houseType): ?><option value="<?php echo ($houseType); ?>" <?php if(($vo['houseType'])  ==  $houseType): ?>selected=selected<?php endif; ?> ><?php echo ($key); ?></option><?php endforeach; endif; ?>
					</select>
					
		        </td>
		        <td align="right" class="formtdl">朝向：</td>
		        <td>
		        	<select name="direction" id="direction" class="fl">    
		        		<option value=-1 selected>请选择</option>
		        		 <?php if(is_array($directionArr)): foreach($directionArr as $key=>$direction): ?><option value="<?php echo ($direction); ?>" <?php if(($vo['direction'])  ==  $direction): ?>selected=selected<?php endif; ?> ><?php echo ($key); ?></option><?php endforeach; endif; ?>
					</select>
		        </td>
		       
		      </tr>
		     
		      <tr>
		        <td align="right" class="formtdl">单价(元)：</td>
		        <td><input type="text" id="unitPrice" size="10" name="unitPrice" value="<?php echo (number_format($vo["unitPrice"],0,',','')); ?>" class="fl"><div id="unitPriceTip" class="onShow tips" style="width:150px;">请输入总价</div></td>
		        <td align="right" class="formtdl">装修：</td>
		        <td>
		        		<select name="decoration" id="decoration" class="fl">    
			        		<option value=-1 selected>请选择</option>
			        		 <?php if(is_array($decorationArr)): foreach($decorationArr as $key=>$decoration): ?><option value="<?php echo ($decoration); ?>" <?php if(($vo['decoration'])  ==  $decoration): ?>selected=selected<?php endif; ?> ><?php echo ($key); ?></option><?php endforeach; endif; ?>
						</select>
				</td>
		       
		      </tr>
		      <tr>
		        <td align="right" class="formtdl">产证面积：</td>
		        <td><input type="text" id="area" size="10" name="area" value="<?php echo (number_format($vo["area"],0,',','')); ?>" class="fl"><div id="areaTip" class="onShow tips" style="width:140px;">请输入</div></td>
		        <td align="right" class="formtdl">产权面积：</td>
		        <td><input type="text" id="propertyRightArea" size="10" name="propertyRightArea" value="<?php echo (number_format($vo["propertyRightArea"],0,',','')); ?>" class="fl"><div id="propertyRightAreaTip" class="onShow tips" style="width:140px;">请输入楼层</div></td>
		       
		      </tr>
		      <tr>
		        <td align="right" class="formtdl">使用面积：</td>
		        <td><input type="text" id="useArea" size="10" name="useArea" value="<?php echo (number_format($vo["useArea"],0,',','')); ?>" class="fl"><div id="useAreaTip" class="onShow tips" style="width:140px;">请输入总价</div></td>
		        <td align="right" class="formtdl">房龄：</td>
		        <td><input type="text" id="houseAge" size="10" name="houseAge" value="<?php echo (number_format($vo["houseAge"],0,',','')); ?>" class="fl"><div id="houseAgeTip" class="onShow tips" style="width:140px;">请输入正整数</div></td>
		       
		      </tr>
		       <tr>
		        <td align="right" class="formtdl">区域：</td>
		        <td><select name="districtID" id="districtID" class="fl">
		        		<option value=-1>请选择</option>
		        		<?php if(is_array($distList)): $i = 0; $__LIST__ = $distList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dist): ++$i;$mod = ($i % 2 )?><option value="<?php echo ($dist["id"]); ?>" <?php if(($dist['id'])  ==  $vo["districtID"]): ?>selected=selected<?php endif; ?> ><?php echo ($dist["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
		        	</select>
		        	
		        <div id="districtIDTip" class="onShow tips" style="width:150px;">请选择</div></td>
		        <td align="right" class="formtdl">物业类型：</td>
		        <td>
		        	<select name="type" id="type"  class="fl" >		        		
		        			<option value="-1" >请选择</option>
		        		 	<option value="1" <?php if(($vo['type'])  ==  "1"): ?>selected=selected<?php endif; ?> >新房</option>
		        		 	<option value="2" <?php if(($vo['type'])  ==  "2"): ?>selected=selected<?php endif; ?> >二手房</option>
					</select>
					
		        	
		        </td>
		       
		      </tr>
		     
		       <tr>
		        <td align="right" width="12%" class="formtdl">地址：</td>
		        <td align="left" colspan="3"><input type="text" id="address" size="50" name="address" value="<?php echo ($vo["address"]); ?>" class="fl">
		        <div id="addressTip" class="onShow tips" style="width:200px;">请输入</div></td>
		      </tr>
		       <tr>
		        <td align="right" width="12%" class="formtdl">小区：</td>
		        <td align="left" colspan="3"><input type="text" id="communityName" size="50" name="communityName" value="<?php echo ($vo["communityName"]); ?>" class="fl">
		        	<div id="communityNameTip" class="onShow tips" style="width:200px;">请输入小区名称</div></td>
		      </tr>
		     
			  <tr>
		        <td align="right" width="12%" class="formtdl">开发商：</td>
		        <td align="left" colspan="3"><input type="text" id="develop" size="50" name="develop" value="<?php echo ($vo["develop"]); ?>" class="fl">
		        </td>
		      </tr>
		      
		    </tbody></table>
		    <div class="ydbar">
		      <div class="info-title">房源介绍</div>
		    </div>
		    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		      <tbody><tr>
		        <td><textarea class="ckeditor" name="description" cols="50" rows="10" id="description" ><?php echo ($vo["description"]); ?></textarea>
		        <div id="descriptionTip" class="onShow tips" style="width:200px;">请输入房源介绍</div></td>
		      </tr>
		   		     
		    </tbody></table>
		    
		    <div class="ydbar">
		      <div class="info-title">推荐说明</div>
		    </div>
		    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		      <tbody><tr>
		        
		        <td align="left" colspan="4"><input type="text" id="recommendation" size="100" name="recommendation" value="<?php echo ($vo["recommendation"]); ?>" class="fl">
		        <div id="recommendationTip" class="onShow tips" style="width:200px;">请最多输入50个字</div></td>
		      </tr>
		   		     
		    </tbody></table>
		    
		    <div class="ydbar">
		      <div class="info-title">房源图片</div>
		    </div>
		    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		    	
		      <tbody>
		        <tr><td>
		        	<input type="hidden" name="delPicID" id="delPicID" value="" />
		        	<?php if(is_array($picList)): $i = 0; $__LIST__ = $picList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): ++$i;$mod = ($i % 2 )?><div class="pro_picList" id="pic<?php echo ($pic['id']); ?>">
		        			<img src="<?php echo ($pic['thumb']); ?>" width="100" height="100"/>
		        			<p>	<input type="checkbox" <?php if(($pic['recommendation'])  ==  "1"): ?>checked<?php endif; ?> onclick="recommendationPic(<?php echo ($pic['id']); ?>,this)" title="设置推荐图">
		        				<?php echo (msubstr($pic['title'],0,4,'utf-8',false)); ?>&nbsp;
		        				<a href="javascript:void(delPic(<?php echo ($pic['id']); ?>));">删除</a></p>
		        		</div><?php endforeach; endif; else: echo "" ;endif; ?>
		        </td></tr>
		      	<tr>
		        	<td>
		        		<input type="button" onclick="addFileUpload();" value="添加图片" />
        <br />			<span id="files">
		        			<div id="fileDiv0">图片名称&nbsp;<input type="text" name="fileName[]">&nbsp;<input type="file" name="file[]"><a href="javascript:void(delFile('fileDiv0'));">删除</a></a><br></div>
		        		</span>
		        		</td>
		      	</tr>

		     
		    </tbody></table>
		    
		    <div class="ydbar">
		      <div class="info-title">地图标注</div>
		    </div>
		    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		      <tbody><tr>
		        
		        <td><div id="container" class="maps"></div>
		        </td>
		      </tr>

		     
		    </tbody></table>
		    
		    <div class="ydbar">
		      <div class="info-title">周边配套信息</div>
		    </div>
		    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-f">
		      <tbody> 
		      <tr>
		        <td align="right" width="12%" class="formtdl">地铁：</td>
		        <td align="left" colspan="2"><input type="text" id="subway" size="50" name="subway" value="<?php echo ($vo["subway"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		      <tr>
		        <td align="right" width="12%" class="formtdl">公交：</td>
		        <td align="left" colspan="2"><input type="text" id="bus" size="50" name="bus" value="<?php echo ($vo["bus"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		      <tr>
		        <td align="right" width="12%" class="formtdl">临近交通枢纽：</td>
		        <td align="left" colspan="2"><input type="text" id="transportHub" size="50" name="transportHub" value="<?php echo ($vo["transportHub"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		      <tr>
		        <td align="right" width="12%" class="formtdl">学校：</td>
		        <td align="left" colspan="2"><input type="text" id="school" size="50" name="school" value="<?php echo ($vo["school"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		      <tr>
		        <td align="right" width="12%" class="formtdl">幼儿园：</td>
		        <td align="left" colspan="2"><input type="text" id="kindergarten" size="50" name="kindergarten" value="<?php echo ($vo["kindergarten"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		      <tr>
		        <td align="right" width="12%" class="formtdl">商场：</td>
		        <td align="left" colspan="2"><input type="text" id="shopping" size="50" name="shopping" value="<?php echo ($vo["shopping"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		      <tr>
		        <td align="right" width="12%" class="formtdl">医院：</td>
		        <td align="left" colspan="2"><input type="text" id="hospital" size="50" name="hospital" value="<?php echo ($vo["hospital"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		      <tr>
		        <td align="right" width="12%" class="formtdl">银行：</td>
		        <td align="left" colspan="2"><input type="text" id="bank" size="50" name="bank" value="<?php echo ($vo["bank"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		      <tr>
		        <td align="right" width="12%" class="formtdl">邮局：</td>
		        <td align="left" colspan="2"><input type="text" id="post" size="50" name="post" value="<?php echo ($vo["post"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		      <tr>
		        <td align="right" width="12%" class="formtdl">餐饮：</td>
		        <td align="left" colspan="2"><input type="text" id="dining" size="50" name="dining" value="<?php echo ($vo["dining"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		       <tr>
		        <td align="right" width="12%" class="formtdl">临近商业中心：</td>
		        <td align="left" colspan="2"><input type="text" id="businessCenter" size="50" name="businessCenter" value="<?php echo ($vo["businessCenter"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		       <tr>
		        <td align="right" width="12%" class="formtdl">其它：</td>
		        <td align="left" colspan="2"><input type="text" id="ortherFacility" size="50" name="ortherFacility" value="<?php echo ($vo["ortherFacility"]); ?>"></td>
		        <td align="left" width="35%"></td>
		      </tr>
		     
		    </tbody></table>
    
		    <table width="100%" cellspacing="0" cellpadding="0" border="0">
		      <tbody><tr>
		          <td align="center">
		            <input type="submit" value="确定" id="button" class="inp-yd" name="button">
		            
		        </td></tr>
		    </tbody></table>
		  </form>
             
          </div><!-- cbox end -->
            
			            
			        </div><!-- right_area end -->
				</div>
				
				<div class="clear"></div>
			</div> <!-- content end-->
			<div id="footer"></div>
   		</div><!-- wrapper end-->
</body>
</html>