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
      isset($_GET['qqNumber']) &&
      isset($_GET['imgList']) &&
      isset($_GET['marqueeContent']) &&
      isset($_GET['reserve1']) &&
      isset($_GET['reserve2']) &&
      isset($_GET['reserve3']) &&
      isset($_GET['comment'])) {

    $login_user_id = get_login_user_id();
    
    $url = $_GET['url'];
    $appid = $_GET['appid'];
    $type = $_GET['type'];
    $show = $_GET['show'];
    $comment = $_GET['comment'];

    $qqNumber = $_GET['qqNumber'];
    $imgList = $_GET['imgList'];
    $marqueeContent = $_GET['marqueeContent'];

    $reserve1 = $_GET['reserve1'];
    $reserve2 = $_GET['reserve2'];
    $reserve3 = $_GET['reserve3'];

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
        $sql = "insert into lottery(url,show_url,type,appid,updateAt,comment, ImgList, marqueeContent, qqNumber, reserve1, reserve2, reserve3, create_user_id) values
                ('$url', $show, '$type', '$appid', '$createAt', '$comment', '$imgList', '$marqueeContent', '$qqNumber', '$reserve1', '$reserve2', '$reserve3', '$login_user_id')";
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
