<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
	$(document).keyup(function(event){
		if(event.keyCode ==13){
			denglu();
		}
	});
	function denglu()
	{
		var password = $("#password").val();
		if(password)
		{
			var url = 'denglu.php';
			$.ajax({
				url:url,
				type:'POST',
				data:{
					'password':password
				},
				success:function(data,txtstatus){
					if(data==1)
					{
						location.href = 'index.php';
					}
					else
					{
						$(".error").css("display","block");
					}
				}
			});
		}
		else
		{
			$(".error").css("display","block");
		}
	}
	function del_pwd()
	{
		$(".error").css("display","none");
	}

</script>
<title>登陆</title>
</head>

<body class="login_index">
<div class="form">
	<div class="login">
    	<p class="img"><img src="images/login_01.png" /></p>
        <p class="tijiao">
        	<label>密码：</label>
            <span class="pwd"><input type="password" id="password" name="password" onfocus="del_pwd()" /><input type="button" id="but" value="确定" onclick="denglu()" /></span>
            <div class="clear"></div>
            <span class="error" style="display:none">密码错误</span>
        </p>
    </div>
    <img src="images/login_02.png" />
</div>
</body>
</html>
