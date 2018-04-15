<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>后台管理</title>
	<link rel="stylesheet" type="text/css" href="/Public/css/admin/style.css" />
	<script type="text/javascript" src="/Public/js/jquery-1.4.4.js"></script>
	<script type="text/javascript" src="/Public/admin/js/common.js"></script>
	<script>
	 function encodingForm(){
		 document.getElementById("productName").value = encodeURIComponent(document.getElementById("productName1").value);
	 }

	 function sort(id,sortVal){
		
			 	$.ajax({
				  url: '__URL__/sortUp',
				  data: {'id': id,'sortVal':sortVal},
				  success: function(data) {
				   	if(data!="success"){
					   	alert("修改排行失败");
				   	}
				  }
				});
				
           
			
		}
	</script>
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
		menusel('house');
	</script>
	
	
				<div class="right_area">
					<div class="cbar">
			            
			              <ul>
			                <li class="cbar-tag-sel"><a href="__URL__/index">新房查询</a></li>
			    			<li><a href="__URL__/add">添加新房源</a></li>
			              </ul>
			         </div><!-- cbar end -->
			         
			         <div class="cbox">
          <form action="__URL__/index" method="get" name="form1" onsubmit="encodingForm()">
            <div class="ydbar">
              <div class="info-title">快速检索</div>
            </div>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-f">
              <tbody>
              <tr>
                <td width="10%" align="right" class="formtdl">使用面积：</td>
                <td width="40%"><select name="useArea">
						<option value="0">不限</option>                   
		                   <?php if(is_array($areaArr)): foreach($areaArr as $key=>$area): ?><option value="<?php echo ($area); ?>" <?php if($useArea == $area): ?>selected=selected<?php endif; ?> ><?php echo ($key); ?></option><?php endforeach; endif; ?>
                    </select>
                </td>
               
               <td width="10%" align="right" class="formtdl">价格：</td>
                <td width="40%"><select name="totalPrice" id="price">
						<option value="0">不限</option>
		                   <?php if(is_array($priceArr)): foreach($priceArr as $key=>$price): ?><option value="<?php echo ($price); ?>" <?php if($totalPrice == $price): ?>selected=selected<?php endif; ?> ><?php echo ($key); ?></option><?php endforeach; endif; ?>
		              </select>
                </td>
              </tr>
              <tr>
                <td width="10%" align="right" class="formtdl">户型：</td>
                <td width="40%"><select name="houseType" >
                			<option value="0">不限</option>
							<?php if(is_array($houseTypeArr)): foreach($houseTypeArr as $key=>$htype): ?><option value="<?php echo ($htype); ?>" <?php if($houseType == $htype): ?>selected=selected<?php endif; ?> ><?php echo ($key); ?></option><?php endforeach; endif; ?>
                    </select>
                </td>
               
               <td width="10%" align="right" class="formtdl">区域：</td>
                <td width="40%"><select name="districtID"  id="sprice">
                	<option value="0">不限</option>
                	<?php if(is_array($distList)): foreach($distList as $key=>$dist): ?><option value="<?php echo ($dist["id"]); ?>" <?php if(($dist['id'])  ==  $districtID): ?>selected=selected<?php endif; ?> ><?php echo ($dist["name"]); ?></option><?php endforeach; endif; ?>
		           </select>
                </td>
              </tr>
              <tr>
                <td align="right" class="formtdl">房源名称：</td>
                <td>
                	<input type="hidden" name="productName" id="productName" size="35" value="<?php echo ($productName); ?>" />
                	<input type="text" id="productName1" size="30" value="<?php echo ($productName); ?>" /> </td>
                <td align="right" class="formtdl">房源类型：</td>
                <td><select name="type" size="1" id="sprice">
                		<option value="0">不限</option>
						<option value="1" <?php if($type == 1): ?>selected=selected<?php endif; ?> >新房</option>
						<option value="2" <?php if($type == 2): ?>selected=selected<?php endif; ?> >二手房</option>
		            </select>
		        </td>
              </tr>
             
            </tbody></table>
            <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-x">
              <tbody><tr>
                <td>
                    <div class="c-col-r btn-add">
                      <div class="btn-add-l"></div>
                      <h4><center><input type="submit" value="查询" class="inp-yd"></center></h4>
                      <div class="btn-add-r"></div>
                    </div>
                    </td>
              </tr>
            </tbody></table>
            </form>
            <div class="ydbar">
      			<div class="info-title">房源列表</div>
    		</div>	
            <table align="center" width="100%" cellspacing="0" cellpadding="0" border="0" class="table_b">
              <tbody><tr class="tab-top">
                <td align="center" width="10%"><strong>房源编号</strong></td>
                <td align="center" width="15%"><strong>房源名称</strong></td>
                <td align="center" width="10%"><strong>区域</strong></td>
                <td align="center" width="10%"><strong>面积</strong></td>
                <td align="center" width="15%"><strong>房型</strong></td>
                <td align="center" width="15%"><strong>售价</strong></td>
                <td align="center" width="10%"><strong>单价/平方</strong></td>
                <td align="center" width="5%" title="输入序号后点击一下输入框旁边的其它地方即可修改"><strong>排序</strong></td>
                <td align="center" width="10%"><strong>操作</strong></td>
              </tr>              
               
               
               <?php if(is_array($houseList)): $i = 0; $__LIST__ = $houseList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$house): ++$i;$mod = ($i % 2 )?><tr onmouseout="this.className=&quot;table-d-c&quot;" onmouseover="this.className=&quot;td-m&quot;" class="table-d-c">
				<td align="center"><?php echo ($house["id"]); ?></td>
                <td align="center"><a target="_blank" href="/house/view?id=<?php echo ($house["id"]); ?>"><?php echo ($house["productName"]); ?></a></td>
                <td align="center">
                	<?php if(is_array($distList)): foreach($distList as $key=>$dist): ?><?php if(($house['districtID'])  ==  $dist["id"]): ?><?php echo ($dist["name"]); ?><?php endif; ?><?php endforeach; endif; ?>
                </td>
                <td align="center"><?php echo (number_format($house["useArea"],0)); ?>㎡</td>
                <td align="center">
                	<?php if(is_array($houseTypeArr)): foreach($houseTypeArr as $key=>$type): ?><?php if(($house['houseType'])  ==  $type): ?><?php echo ($key); ?><?php endif; ?><?php endforeach; endif; ?>
                </td> 
                <td align="center"><?php echo (number_format($house["totalPrice"],0)); ?>万</td>
                <td align="center"><?php echo (number_format($house["unitPrice"],0)); ?></td>
                <td align="center"><input type="text" name="sort" value="<?php echo ($house["sort"]); ?>" onblur="sort('<?php echo ($house["id"]); ?>',this.value)" size=2/></td>
                <td align="center"><a href="__URL__/edit?id=<?php echo ($house["id"]); ?>">编辑</a> |
                 <a onclick="return confirm( '是否需要删除? ');" href="__URL__/delete?id=<?php echo ($house["id"]); ?>">删除</a>
                </td>
              </tr><?php endforeach; endif; else: echo "" ;endif; ?>
             
			  <tr><td colspan=8 align="center"><?php echo ($page); ?></td></tr>
            </tbody></table>
            

          </div><!-- cbox end -->
            
			            
			        </div><!-- right_area end -->
				</div>
				
				<div class="clear"></div>
			</div> <!-- content end-->
			<div id="footer"></div>
   		</div><!-- wrapper end-->
</body>
</html>