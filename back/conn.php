<?php

	$con = mysql_connect("localhost", "www_bai0837_com", "app_manager");
	//设置字符集为utf8
	mysql_query("SET NAMES 'utf8'");

	if (!$con){
		die(mysql_error());
	}

	mysql_select_db("www_bai0837_com", $con);
?>
