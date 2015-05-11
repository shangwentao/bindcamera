<?php
	
	//link to mysql
	$mysql_server_name="localhost"; //数据库服务器名称
	$mysql_username="root"; // 连接数据库用户名
	$mysql_password="123456"; // 连接数据库密码
	$mysql_database="om_im_db"; // 数据库的名字

	$dsn = 'mysql:host='.$mysql_server_name.';dbname='.$mysql_database.';';
	$dbh = new PDO($dsn,$mysql_username,$mysql_password);
	$dbh -> exec("SET NAMES 'utf8';");

?>