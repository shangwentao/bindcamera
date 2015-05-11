<?php
	include("islogin.php");
	include("common.php");
	include("function.php");

	$mac   = deal_html($_POST['mac']);
	$im_id = $_POST['im'];
	$http  = deal_html($_POST['http']);
	$name  = deal_html($_POST['name']);

	$sql = "insert into camera(name,mac,http,order_id,im_id) values('".$name."','".$mac."','".$http."','','".$im_id."')";
	$dbh -> exec("SET NAMES 'utf8';");
	$stmt = $dbh -> query($sql);

	echo true;
?>