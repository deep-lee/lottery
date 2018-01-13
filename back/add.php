<?php

include 'conn.php';
include 'session.php';

$returnData = array();

if (check_user_login_out_of_time() == false) {
  $returnData['rt_code'] = -2;
} else {
  if (isset($_GET['url']) &&
      isset($_GET['appid']) &&
      isset($_GET['type']) &&
      isset($_GET['show']) &&
      isset($_GET['comment'])) {
    $url = $_GET['url'];
    $appid = $_GET['appid'];
    $type = $_GET['type'];
    $show = $_GET['show'];
    $comment = $_GET['comment'];
    date_default_timezone_set('Asia/Shanghai');
    $createAt =  date('Y-m-d H:i:s');

    // echo $url." ".$appid." ".$type." ".$show." ".comment." ".$createAt;

    // 首先检查appid是否重复
    $sql_check_dup = "select * from lottery where appid='$appid'";
    $result_check_dup = mysql_query($sql_check_dup);
    if ($result_check_dup == false) {
      $returnData['rt_code'] = 0;
    } else {
      if (mysql_num_rows($result_check_dup) != 0) {
        // 有重复的appid
        $returnData['rt_code'] = 2;
      } else {
        $sql = "insert into lottery(url,show_url,type,appid,updateAt,comment) values
                ('$url', $show, '$type', '$appid', '$createAt', '$comment')";
        $result = mysql_query($sql);
        if ($result == false) {
          $returnData['rt_code'] = 0;
        } else {
          $returnData['rt_code'] = 1;
        }
      }
    }
  } else {
    $returnData['rt_code'] = -1;
  }
}

echo json_encode($returnData);
