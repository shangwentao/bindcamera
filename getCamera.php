<?php
	include("islogin.php");
	include("common.php");
	include("function.php");

	//重置搜索
	if(isset($_GET['tag']))
	{
		//session_destroy();
		$_SESSION['type']='im_id';
		$_SESSION['content']='';
		$_SESSION['code']='im_id';
		$_SESSION['sc']=2;
		echo 1;
		exit;
	}
	//详情页
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$sql = "select a.id,a.name,a.mac,a.http,a.im_id,a.status,b.corp_name from camera as a left join biz_company_detail as b on b.corp_id=a.school_id where a.id='".$id."'";
		$stmt = $dbh -> query($sql);
		$row_school = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		
		if($row_school[0]['corp_name']!=''){
			$sql = "SELECT id,room_name from classroom where id = (SELECT room_id from camera_room WHERE camera_id='".$id."')";
			$stmt = $dbh -> query($sql);
			$row_room = $stmt -> fetchAll(PDO::FETCH_ASSOC);
			if(!empty($row_room)){
				$room_id=$row_room[0]['id'];
				$room_name=$row_room[0]['room_name'];
				$sql = "SELECT title,start_date,end_date from lesson where lesson_id in (SELECT lesson_id from lesson_room WHERE room_id='".$row_room[0]['id']."')";
				$stmt = $dbh -> query($sql);
				$lesson = $stmt -> fetchAll(PDO::FETCH_ASSOC);
				if(empty($lesson))
				{
					$lesson='';
				}
			}else{
				$room_id='';
				$room_name='';
				$lesson='';
			}
		}else{
			$room_id='';
			$room_name='';
			$lesson='';
		}
		
		$row=array();
		$row['id'] = $row_school[0]['id'];
		$row['name'] = $row_school[0]['name'];
		$row['mac'] = $row_school[0]['mac'];
		$row['im_id'] = $row_school[0]['im_id'];
		$row['http'] = $row_school[0]['http'];
		$row['status'] = $row_school[0]['status'];
		$row['corp_name'] = $row_school[0]['corp_name'];
		$row['room'] = $room_name;
		$row['room_id'] = $room_id;
		$row['lesson'] = $lesson;
		echo json_encode($row);
		exit;
	}else{
		$sql = "select a.id,a.name,a.mac,a.status,a.im_id,b.corp_name from camera as a left join biz_company_detail as b on b.corp_id=a.school_id where 1";
	}
	//搜索
	if(!isset($_SESSION['content']))
	{
		$_SESSION['type']='im_id';
		$_SESSION['content']='';
	}
	if(isset($_GET['content']))
	{
		$type=$_GET['type'];
		$content = deal_html($_GET['content']);
		$sql .= sql_where($type,$content);
		$_SESSION['type'] = $type;
		$_SESSION['content'] = $content;
	}
	else
	{
		$sql .= sql_where($_SESSION['type'],$_SESSION['content']);
	}

	//排序
	if(!isset($_SESSION['code']))
	{
		$_SESSION['code']='im_id';
		$_SESSION['sc']=2;
	}
	if(isset($_GET['code']))
	{
		$sql.= camersas_sort($_GET['code']);
	}
	else{
		if($_SESSION['sc']==2)
		{
			$sql.=" order by ".$_SESSION['code']." desc";
		}
		else
		{
			$sql.=" order by ".$_SESSION['code']." asc";
		}
	}

	$stmt = $dbh -> query($sql);
	$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);

	if(isset($_GET['pagesize']))
	{
		$pagesize=$_GET['pagesize'];
	}
	else if(isset($_SESSION['pagesize']))
	{
		$pagesize=$_SESSION['pagesize'];
	}
	else
	{
		$pagesize=10;
	}
	$_SESSION['pagesize'] = $pagesize;
	//定义分页初始值
	$page=$pageMax=$up=$down='';

	$num=count($row);
	if($num>0)
	{
		//$pagesize=2;
		$pageMax=ceil($num/$pagesize);
		if(isset($_GET['page']))
		{
			$page=($_GET['page']);
		}
		else
		{
			$page=1;
		}
		$start=$pagesize*($page-1);
		$sql.=" limit ".$start.",".$pagesize."";
		$stmt = $dbh -> query($sql);
		$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
		//首页、下一页、上一页、尾页
		if(1==$page)
		{
			$up=1;	
		}
		else
		{
			$up=$page-1;	
		}
		if($page<$pageMax)
		{
			$down=$page+1;	
		}
		else
		{
			$down=$pageMax;	
		}
	}

	$ary=array();
	//$ary['sql'] = $sql;
	$ary['row'] = $row;
	$ary['page'] = $page;
	$ary['pageMax'] = $pageMax;
	$ary['up'] = $up;
	$ary['down'] = $down;
	$ary['type'] = $_SESSION['type'];
	$ary['content'] = $_SESSION['content'];
	$ary['pagesize'] = $_SESSION['pagesize'];
	$ary['code'] = $_SESSION['code'];
	$ary['sc'] = $_SESSION['sc'];
	//echo "<pre/>";
	//print_r ($ary);
	echo json_encode($ary);




function sql_where($type,$content)
{
	$sql='';
	if($content!='')
	{
		$sql.=" and ".$type." like '%$content%' ";
	}
	return $sql;
}
function camersas_sort($code)
{
	if($_SESSION['code']=='')
	{
		$_SESSION['code']=$code;
		$_SESSION['sc']=1;
		return " order by ".$code." asc";
	}
	else
	{
		if($_SESSION['code']==$code)
		{
			$sc=isasc($_SESSION['sc']);
			$_SESSION['sc'] = $sc['b'];
			return " order by ".$code." ".$sc['a'];
		}
		else
		{
			$_SESSION['code'] = $code;
			$_SESSION['sc']=1;
			return " order by ".$code." asc";
		}
	}
}
function isasc($sc)
{
	$ary=array();
	if($sc==1)
	{
		$ary['a']="desc";
		$ary['b']=2;
	}
	else{
		$ary['a']="asc";
		$ary['b']=1;
	}
	return $ary;
}
?>