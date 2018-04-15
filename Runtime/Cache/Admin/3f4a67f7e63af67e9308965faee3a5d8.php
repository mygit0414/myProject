<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>后台管理</title>
	<link href="/Public/css/admin/style.css" rel="stylesheet" type="text/css" />
	<style>
		html,body{background-color: #428ff7;}
		
	</style>
	
	<script>
	$(document).ready(function(){
		$.formValidator.initConfig({formid:"form",onerror:function(msg){alert(msg)},onsuccess:function(){return true;}});
		$("#userName").formValidator({onshow:"请输入用户名",onfocus:"请输入用户名",oncorrect:"输入正确"}).inputValidator({min:4,max:30,onError:"输入错误，请输入4~30个字!"});
		$("#password").formValidator({onshow:"请输入密码",onfocus:"请输入密码",oncorrect:"输入正确"}).inputValidator({min:6,max:30,onError:"输入错误，请输入6~30个字!"});
	});
	</script>
</head>

<body>
	
	
	<form action="__URL__/checkLogin" method="post" >
	<table height="100%" width="100%" >
		
		<tr valign=middle align=center>
			<td>
				<table border=0>
					<tr valign=middle align=center><td style="font-size:20px;color: red;"><?php if(!empty($loginMessage)): ?>错误提示：<?php echo ($loginMessage); ?><?php endif; ?></td></tr>
				</table>
				
				<table border=0>
					<tr valign=middle align=center><td style="font-size:20px;">后台管理</td></tr>
				</table>
				
				<table>
				
				<tr >
					<td>用户名：</td>
					<td><input type="text" name="loginName" style="width:150px;"/></td>
					<td><div id="userNameTip" class="onShow"></div></td>
				</tr>
				<tr >
					<td>密码：</td>
					<td><input type="password" name="password" style="width:150px;"/></td>
					<td><div id="passwordTip" class="onShow"></div></td>
				</tr>
				<tr >
					<td colspan="3" align="center"><input type="radio" name="PersistentCookie" value="1" />下次自动登录<input class="login-btn" type="submit" value="登   录"/></td>
					
				</tr>
				</table>
			</td>
		</tr>
	</table>
	
	</form>
</body>
</html>