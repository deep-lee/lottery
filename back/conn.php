<?php

	$con = mysql_connect("localhost", "app_manager", "app_manager");
	//设置字符集为utf8
	mysql_query("SET NAMES 'utf8'");

	if (!$con){
		die(mysql_error());
	}

	mysql_select_db("app_manager", $con);
?>
