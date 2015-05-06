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
<title>摄像头列表</title>
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript">
	$(document).keyup(function(event){
		if(event.keyCode ==13){
			searchCameras();
		}
	});
	function redriect(){
		location.href = 'addCamera.php';
	}

	function change_pagesize()
	{
		var pagesize = $("#pagesize").val();
		var url = 'getCamera.php';
  		$.ajax({
  			url:url,
  			type:'GET',
			data:{
				page:1,
  				pagesize:pagesize
  			},
  			success:function(data,txtstatus){
  				var d = JSON.parse(data);
  				showCameras(d);
				location.href = 'index.php';
  			}
  		});
	}

	function sort(code)
	{
		switch (code)
		{
			case 1:var code1="name";break;
			case 2:var code1="status";break;
			case 3:var code1="mac";break;
			case 4:var code1="im_id";break;
			case 5:var code1="corp_name";break;
		}
		var url = 'getCamera.php';
  		$.ajax({
  			url:url,
  			type:'GET',
			data:{
  				code:code1
  			},
  			success:function(data,txtstatus){
  				var d = JSON.parse(data);
  				showCameras(d);
  			}
  		});
	}

  	function showCameras(cameras){
		//alert(cameras.sql);
		switch (cameras.type)
		{
			case 'name':$("#type").html('摄像头名字');break;
			case 'mac':$("#type").html('MAC地址');break;
			case 'corp_name':$("#type").html('使用学校');break;
			default:$("#type").html('一米分配ID');break;
		}
		$('#content').val(cameras.content);
		$('#pagesize').val(cameras.pagesize);

  		var _html = '';
		_html+='<tr class="tit"><th scope="col" class="first" onclick="sort(1);" id="name">摄像头名字</th><th scope="col" onclick="sort(2);" id="status">摄像头状态</th><th scope="col" onclick="sort(3);" id="mac">MAC地址</th><th scope="col" onclick="sort(4);" id="im_id">一米分配ID</th><th scope="col" onclick="sort(5);" id="corp_name">使用学校</th><th scope="col"></th></tr>';
  		var size = cameras.row.length;
  		for(var i=0;i<size;i++){
  			var d = cameras.row[i];
			if(!d['corp_name'])
			{
				d['corp_name']='';
			}
			_html +='<tr><td class="first">'+d['name']+'</td><td><img class="icon" src="images/scri'+d['status']+'.png" /></td><td>'+d['mac']+'</td><td>'+d['im_id']+'</td><td>'+d['corp_name']+'</td><td><a href="contentCamera.php?id='+d['id']+'">详情</a></td></tr>';
  		}

		var _page='';
		if(cameras.pageMax>1){
				_page +='';
				if(cameras.page!=1){
					_page +='<a href="?page=1">首页</a> ';
					_page +='<a href="?page='+cameras.up+'">上一页</a> ';
				}

				for(var m=1;m<cameras.pageMax+1;m++){
					var class_name = '';
					if(m==cameras.page){class_name+=" class='page_curr' ";}
					_page +='<a href="?page='+m+'" '+class_name+'>'+m+'</a> ';
				}

				if(cameras.page!=cameras.pageMax){
					_page +='<a href="?page='+cameras.down+'">下一页</a> ';
					_page +='<a href="?page='+cameras.pageMax+'">末页</a> ';
				}
				
		}
  		$('.table').html(_html);
		$('.page b').html(_page);
		$("#"+cameras.code).append('<img src="images/sort'+cameras.sc+'.png" />');
		
		
  	}

  	function getAllCameras(){
		var str = location.href.split('page=');
  		var page = str[1];
		if(!page)
		{
			page=1;
		}
  		var url = 'getCamera.php';
  		$.ajax({
  			url:url,
  			type:'GET',
			data:{
  				page:page
  			},
  			success:function(data,txtstatus){
  				var d = JSON.parse(data);
  				showCameras(d);
  			}
  		});
  	}

	function searchCameras()
	{
		var str = location.href.split('page=');
  		var page = str[1];
		if(!page)
		{
			page=1;
		}
		var type1 = $("#type").html();
		var content = $("#content").val();
		var type='im_id';
		switch (type1)
		{
			case '摄像头名字':type='name';break;
			case 'MAC地址':type='mac';break;
			case '使用学校':type='corp_name';break;
		}
		var url = 'getCamera.php';
  		$.ajax({
  			url:url,
  			type:'GET',
			data:{
  				type:type,
				content:content,
				page:page
  			},
  			success:function(data,txtstatus){
  				var d = JSON.parse(data);
  				showCameras(d);
  			}
  		});
	}

	function resetCameras()
	{
		var url = 'getCamera.php';
		$.ajax({
  			url:url,
  			type:'GET',
			data:{
				tag:"reset"
			},
  			success:function(data,txtstatus){
				getAllCameras();
  				if(data==1)
				{
					$('#type').html('一米分配ID');
					$('#content').val('');
				}
  			}
  		});
	}

	function color_content(id)
	{
		if(id==1){
			$("#content").css("color","#000");
		}else{
			$("#content").css("color","#bfbfbf");
		}
	}
	

  	$(function(){
  		getAllCameras();
  	});

	$(document).ready(function(){
		$('.son_ul').hide(); //初始ul隐藏
		$('.select_box span').hover(function(){ //鼠标移动函数
			$(this).parent().find('ul.son_ul').slideDown();  //找到ul.son_ul显示
			$(this).parent().find('li').hover(function(){$(this).addClass('hover')},function(){$(this).removeClass('hover')}); //li的hover效果
			$(this).parent().hover(function(){},function(){
				$(this).parent().find("ul.son_ul").slideUp(); 
			}
		);
		},function(){}
		);
		$('ul.son_ul li').click(function(){
			$(this).parents('li').find('span').html($(this).html());
			$(this).parents('li').find('ul').slideUp();
		});
	}
	);

  </script>
</head>

<body class="content_list">
<div class="list">
	<h3><a href="javascript:;" onclick="redriect()" class="add_bot"><img src="images/add_bot.png" />新增</a>
    	<div class="po_ab">
			<ul id="main_box">
				<li class="select_box">
					<span id="type" name="type">一米分配ID</span>
					<ul class="son_ul">
						<li>一米分配ID</li>
						<li>摄像头名字</li>
						<li>MAC地址</li>
						<li>使用学校</li>
					</ul>
				</li>
			</ul>
            <input type="text" value="" name="content" id="content" onfocus="color_content(1)" onblur="color_content(2)" />
            <input type="button" onclick="searchCameras()" />
			<p onclick="resetCameras();">重置</p>
        </div>
    </h3>
    <table width="100%" border="0" class="table">

    </table>
</div>
<div class="page">
	<span>一页<input type="text" class="pagesize" id="pagesize" value="" onblur="change_pagesize()" />行</span> 
	<b></b>
</div>
</body>
</html>
