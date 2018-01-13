<?php

	$con = mysql_connect("116.31.99.213", "root", "Sc/NGr)Lqh");
	//设置字符集为utf8
	mysql_query("SET NAMES 'utf8'");

	if (!$con){
		die(mysql_error());
	}

	mysql_select_db("mydb", $con);
?>
