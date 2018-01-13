<?php
// 允许跨域访问
header("Access-Control-Allow-Origin: *");

include 'conn_memcached.php';
include 'My.php';

$db_host = 'localhost';
$db_name = 'mydb';
$db_user = 'root';
$db_pwd = 'hpidc@126';

if (isset($_GET["appid"]) && isset($_GET["type"])) {
  //面向对象方式
  // $mysqli = new mysqli($db_host, $db_user, $db_pwd, $db_name);
  $appid = $_GET["appid"];
  $type = $_GET["type"];

  //缓存服务器中，都是键值对，这里我们设定唯一的键
  $key = md5($appid);

  $cache_result = array();
  //根据键，从缓存服务器中获取它的值
  $cache_result = $mem->get($key);
  //如果存在该键对应的值，说明缓存中存在该内容

  $dbConnection = new PDO('mysql:dbname=mydb;host=127.0.0.1;charset=utf8', $db_user, $db_pwd);

  $dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if($cache_result){
    // 已经缓存了
    // echo "get from memcached";
    $data_result=$cache_result;
  } else {
    // echo "get from mysql";
    $stmt = $dbConnection->prepare('SELECT * FROM lottery WHERE appid = :appid and type = :type');
    $stmt->execute(array(':appid' => $appid, ':type' => $type));
    foreach ($stmt as $row) {
      $data_result = $row;
    }
    $mem->set($key, $data_result, MEMCACHE_COMPRESSED, 3600);
  }

  // update request number

  $sql_request_num = "select request_num from lottery WHERE appid=:appid";
  $stmt_request_num = $dbConnection->prepare($sql_request_num);
  $stmt_request_num->execute(array(':appid' => $appid));
  foreach ($stmt_request_num as $row) {
    $request_num_result = $row;
  }

  $request_num = $request_num_result['request_num'];

  $request_num = $request_num + 1;

  $sql = "UPDATE lottery SET request_num=:request_num WHERE appid=:appid";
  // Prepare statement
  $stmt2 = $dbConnection->prepare($sql);
  $stmt2->execute(array(':appid' => $appid, ':request_num' => $request_num));
  // execute the query
  $stmt2->execute();

  MySuccess($data_result, 200);

  MyError(101, 201);

} else {
  MyError(100, 201);
}
