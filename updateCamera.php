<?php
	include("islogin.php");
	include("common.php");

	$id   = $_GET['id'];
	$name = $_GET['name'];
	$val  = $_GET['val'];

	$sql = "update camera set ".$name."='".$val."' where id=".$id;
	echo $sql;
	error_log($sql);
	$stmt = $dbh -> query($sql);
	//echo 1;
?>