<?php

include 'conn.php';
include 'session.php';
include 'conn_memcached.php';

$returnData = array();
if (check_user_login_out_of_time() == false) {
  $returnData['rt_code'] = -2;
} else {
  if (isset($_GET['id']) &&
      isset($_GET['url']) &&
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
    $id = $_GET['id'];
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
    $updateAt = date('Y-m-d H:i:s');

    // echo $id." ".$url." ".$appid." ".$type." ".$show." ".comment." ".$updateAt;

    $sql = "update lottery set url = '$url', appid='$appid', type='$type',
            show_url=$show, comment='$comment', updateAt='$updateAt', ImgList='$imgList', marqueeContent='$marqueeContent', qqNumber='$qqNumber',
            reserve1='$reserve1', reserve2='$reserve2', reserve3='$reserve3'
            where id=$id";

    $result = mysql_query($sql);
    // remove from memcache
    $key=md5($appid);
    $mem->delete($key);
    if ($result == false) {
      $returnData['rt_code'] = 0;
    } else {
      $returnData['rt_code'] = 1;
    }
  } else {
    $returnData['rt_code'] = -1;
  }
}

echo json_encode($returnData);
