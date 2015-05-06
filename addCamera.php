<?php
	include("islogin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link href="style.css" rel="stylesheet" type="text/css" />
<title>添加摄像头</title>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
	function redriect(){
		location.href = 'index.php';
		
		
	}

	function addNewCamera(name,mac,im,http){
		var url = 'register.php';
		$.ajax({
			url:url,
			type:'POST',
			data:{
				'name':name,
				'mac':mac,
				'im':im,
				'http':http
			},
			success:function(data,txtstatus){
				if(data){
					redriect();
				}
			}
		});
	}

	//检测camera 是否唯一
	function checkCameraUnique(name,mac,im,http){
		var url = 'checkUnique.php';
		$.ajax({
			url:url,
			'type':'POST',
			data:{
				'mac':mac,
				'im':im,
				'http':http
			},
			success:function(data,txtstatus){
				if(data==1){
					addNewCamera(name,mac,im,http);
				}else{
					$("#error").html("摄像头已经被添加。");
					return false;
				}
			}
		});
	}

	function submit1(){
		var name   = $('#name').val();
		var mac    = $('#mac').val();
		var im     = document.getElementById('im').value;
		var http   = $('#http').val();
		
		if(!mac){
			$(".error_mac").html("MAC地址不能为空");
			$("#mac").focus();
			return false;
		}
		if(!im || im=="请点击后方按钮"){
			$(".error_im").html("摄像头ID不能为空");
			return false;
		}
		if(!http)
		{
			$(".error_http").html("摄像头HTTP地址不能为空");
			$("#http").focus();
			return false;
		}
		
		checkCameraUnique(name,mac,im,http);

	}



	function bindSelectSchoolEvent(){
		$('#school_list li').click(function(){
			var school_id = $(this).attr('school_id');
			var school_name = $(this).text();

			if(school_id){
				$('input[name="school_id"]').val(school_id);
				$('input[name="school"]').val(school_name);
				$('#school_list').hide();
			}
		});
	}



	function showCode(d){
		$('input[name="im_id"]').val(d);
		$('#im').css("color","#000");
	}

	function generateCode(){
		// var school_id = $('input[name="school_id"]').val();
		// if(school_id){
		var url = 'generateCode.php';
		$.ajax({
			'url':url,
			'type':'GET',
			// 'data':{
			// 	'school':school_id
			// },
			success:function(data,txtstatus){
				var d = JSON.parse(data);
				showCode(d);
			}
		});
		// }else{
		// 	alert('请先选择学校');
		// }
	}


	function border_color(id,i)
	{
		if(i==1)
		{
			$("#"+id).css("border-bottom-color","#00A0E9");
		}
		else
		{
			$("#"+id).css("border-bottom-color","#BFBFBF");
		}
	}

</script>
</head>

<body>
<div class="add">
	<h1>新增摄像头</h1>
	<form method="post" action="register.php">
		<div>
			<label>摄像头名字</label>
			<span class="content"><input type="text" name="name" id="name" onfocus="border_color(this.id,1)" onblur="border_color(this.id,2)" /><span class="error error_name"></span></span>
            <div class="clear"></div>
		</div>
		<div>
			<label>摄像头MAC地址</label>
			<span class="content"><input type="text" name="mac" id="mac" onfocus="border_color(this.id,1)" onblur="border_color(this.id,2)" /><span class="error error_mac"></span></span>
			<div class="clear"></div>
		</div>
		<div>
			<label>生成摄像头ID</label>
			<span class="content"><input type="text" name="im_id" id="im" readonly="readonly" value="请点击后方按钮" disabled="disabled" /><input type="button" value="生成新摄像头ID" class="button" onclick="generateCode();" /><span class="error error_im"></span></span>
			<div class="clear"></div>
		</div>
		<div>
			<label>摄像头HTTP地址</label>
			<span class="content"><input type="text" name="http" id="http" onfocus="border_color(this.id,1)" onblur="border_color(this.id,2)" /><span class="error error_http"></span></span>
			<div class="clear"></div>
		</div>
		<div>
			<label>&nbsp;</label>
			<span class="content back_del">
				<input type="button" class="submit" onclick="submit1();" value="新增" />
				<input type="button" class="submit back" onclick="redriect();" value="返回" />
			</span>
			<div class="clear"></div>
		</div>
		<div>
			<label>&nbsp;</label>
			<span class="content" id="error"></span>
		</div>
	</form>
</div>
</body>
</html>
