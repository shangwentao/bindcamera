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
<title>摄像头详细页</title>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
	function redriect(){
		location.href = 'index.php';
	}
	function showCamera(d,id){
  		if(typeof d != 'undefined'){
  			$('input[name="name"]').val(d['name']+"("+id+")");
  			$('input[name="mac"]').val(d['mac']);
  			$('input[name="http"]').val(d['http']);
  			$('input[name="im_id"]').val(d['im_id']);
  			$('input[name="school"]').val(d['corp_name']);
			$('input[name="status"]').val(d['status']);
			if(d['room']!=''){
				$('input[name="room"]').val(d['room']+"("+d['room_id']+")");
			}
			if(d['lesson'] != '')
			{
				var len = d['lesson'].length;
				var _html='';
				for(var i=0; i<len; i++){
					var lesson_name='&nbsp;';
					var class_name='class="lesson_plan"';
					if(i==0){
						class_name='';
						lesson_name='课程安排';
					}
					_html+='<div '+class_name+'><label>'+lesson_name+'</label><span class="content edit"><input type="text" name="lesson" value="'+d['lesson'][i]['title']+'&nbsp;&nbsp;'+getLocalTime(d['lesson'][i]['start_date'])+'&nbsp;-&nbsp;'+getLocalTime(d['lesson'][i]['end_date'])+'" disabled="disabled" /></span><div class="clear"></div></div>';
				}
				$("#lesson").html(_html);
			}
			
  		}
  	}
	function getLocalTime(nS) {     
		return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');     
	}     

  	function getCameraById(id){
  		var url = 'getCamera.php';
  		$.ajax({
  			url:url,
  			type:'GET',
  			data:{
  				id:id
  			},
  			success:function(data,txtstatus){
  				var d = JSON.parse(data);
  				showCamera(d,id);
  			}
  		});
  	}

  	$(function(){
  		var str = location.href.split('id=');
  		var id = str[1];
  		if(id){
  			getCameraById(id);
  		}
  	});

	function delCamera(id){
		var url='deletecamera.php';
		$.ajax({
		  url:url,
		  type:'GET',
		  data:{
			'id':id
		  },
		  success:function(data,txtstatus){
			//location.reload(true);
			redriect();
		  }
		});
	  }

	 function bindEvents(){
		var status = $("#status").val();
		if(status==1)
		{
			alert("该摄像头正在使用中，不能删除。");
			return false;
		}

		var str = location.href.split('id=');
  		var id = str[1];
  		
		if(id && confirm('确定删除?') ){
			delCamera(id);
		}

	  }


		
		function update(name)
		{
			$("#"+name).removeAttr("disabled");
			var oldval = $("#"+name).val();
			if(name=="name")
			{
				oldval = oldval.split('(');
				$("#"+name).val(oldval[0]);
			}
			$("#"+name).focus();
			$("#"+name).blur(function() {
				$("#"+name).attr('disabled',"true");
				var editval = $("#"+name).val();
				var str = location.href.split('id=');
  				var id = str[1];
				var url='updateCamera.php';
				$.ajax({
					url:url,
					type:'GET',
					data:{
						'id':id,
						'val':editval,
						'name':name
					},
					success:function(data,txtstatus){
						location.reload(true);
					}
				});
			})
		}
		

</script>
</head>

<body>
<div class="add">
	<h1>摄像头详情</h1>
	<form method="post" action="register.php">
		<div>
			<label>摄像头名字</label>
			<span class="content edit"><input type="text" name="name" id="name" disabled="disabled" /><img src="images/qb.png" width="16px" height="16px" onclick="update('name')" /></span>
            <div class="clear"></div>
		</div>
		<div>
			<label>摄像头MAC地址</label>
			<span class="content edit"><input type="text" name="mac" id="mac" disabled="disabled" /><img src="images/qb.png" width="16px" height="16px" onclick="update('mac')" /></span>
			<div class="clear"></div>
		</div>
		<div>
			<label>生成摄像头ID</label>
			<span class="content edit"><input type="text" name="im_id" id="im_id" disabled="disabled" /></span>
			<div class="clear"></div>
		</div>
		<div>
			<label>直播地址</label>
			<span class="content edit"><input type="text" name="http" id="http" disabled="disabled" /><img src="images/qb.png" width="16px" height="16px" onclick="update('http')" /></span>
			<div class="clear"></div>
		</div>
        <div>
			<label>使用学校</label>
			<span class="content edit"><input type="text" name="school" id="school" disabled="disabled" /></span>
			<div class="clear"></div>
		</div>
        <div>
			<label>使用教室</label>
			<span class="content edit"><input type="text" name="room" id="room" disabled="disabled" /></span>
			<div class="clear"></div>
		</div>
		<div id="lesson">
			<div>
				<label>课程安排</label>
				<span class="content edit"><input type="text" name="lesson" disabled="disabled" /></span>
				<div class="clear"></div>
			</div>
		</div>
        
		<div>
			<label>&nbsp;</label>
			<span class="content back_del detailed">
				<input type="hidden" name="status" id="status" value="" />
				<input type="button" class="submit1" onclick="redriect();" value="返回" />
				<input type="button" class="submit1 back1" onclick="bindEvents();" value="删除" />
			</span>
			<div class="clear"></div>
		</div>

	</form>
</div>
</body>
</html>

