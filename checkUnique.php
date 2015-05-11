<?php
	include("islogin.php");
	include("common.php");
	include("function.php");

	$im_id = deal_html($_POST['im']);
	$http  = deal_html($_POST['http']);
	$mac   = deal_html($_POST['mac']);

	$sql = "select id from camera where http='".$http."' or im_id=binary'".$im_id."' or mac='".$mac."'";
	$dbh -> exec("SET NAMES 'utf8';");
	$result = $dbh->prepare($sql);
	$result->execute();
	$res = $result->fetchAll(PDO::FETCH_ASSOC);

	if(count($res)==0){
		echo true;
	}else{
		echo false;
	}
?>