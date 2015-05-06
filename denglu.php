<?php
	session_start();
	include("function.php");
	$password = deal_html($_POST['password']);
	if($password=='123456'){
		$_SESSION['password']="123456";
		echo 1;
	}
	else{
		$_SESSION['password']="";
		echo 0;
	}
?>