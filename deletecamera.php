<?php
	include("islogin.php");
	include("common.php");

	$id   = $_GET['id'];

	$sql = "delete from camera where id='".$id."'";
	$stmt = $dbh -> query($sql);
	echo true;
?>