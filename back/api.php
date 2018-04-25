<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'conn_memcached.php';
include 'My.php';

$db_user = 'root';
$db_pwd = 'idc@bt1113';

if (isset($_GET["appid"])) {
  //面向对象方式
  // $mysqli = new mysqli($db_host, $db_user, $db_pwd, $db_name);
  $appid = $_GET["appid"];

  // echo $appid;

  //缓存服务器中，都是键值对，这里我们设定唯一的键
  $key = md5($appid);

  $cache_result = array();
  //根据键，从缓存服务器中获取它的值
  $cache_result = $mem->get($key);
  //如果存在该键对应的值，说明缓存中存在该内容
  $dbConnection = new PDO('mysql:dbname=mydb2;host=127.0.0.1;charset=utf8', $db_user, $db_pwd);

  $dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $data_result = array();
  if($cache_result){
    // 已经缓存了
    // echo "get from memcached";
    $data_result=$cache_result;
  } else {
    // echo "get from mysql";
    $stmt = $dbConnection->prepare('SELECT show_url as is_wap, url as wap_url, is_update, update_url FROM lottery WHERE appid = :appid');
    $stmt->execute(array(':appid' => $appid));
    foreach ($stmt as $row) {
      $data_result = $row;
      $data_result['code'] = 200;
      $data_result['msg'] = '';
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

  json_encode($data_result);

} else {
  $data_result = array();
  $data_result['code'] = 201;
  $data_result['msg'] = 'error';
  json_encode($data_result);
}
