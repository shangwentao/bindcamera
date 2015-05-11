<?php
	session_start();
	if(!isset($_SESSION['password']))
	{
		header("location:login.php");
	}
?>