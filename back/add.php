<?php

include 'conn.php';
include 'session.php';

$returnData = array();

//判断是否为ajax请求，后端防止别人利用curl的post抓取数据  
if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])&&strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
  if (check_user_login_out_of_time() == false) {
    $returnData['rt_code'] = -2;
  } else {
    if (isset($_GET['url']) &&
        isset($_GET['appName']) &&
        isset($_GET['appid']) &&
        isset($_GET['type']) &&
        isset($_GET['show']) &&
        isset($_GET['isUpdate']) &&
        isset($_GET['updateUrl']) &&
        isset($_GET['qqNumber']) &&
        isset($_GET['comment'])) {
  
      $login_user_id = get_login_user_id();
      
      $url = $_GET['url'];
      $appid = $_GET['appid'];
      $type = $_GET['type'];
      $show = $_GET['show'];
      $comment = $_GET['comment'];
  
      $qqNumber = $_GET['qqNumber'];
  
      $appName = $_GET['appName'];
  
      $isUpdate = $_GET['isUpdate'];
      $updateUrl = $_GET['updateUrl'];
  
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
          $sql = "insert into lottery(url,show_url,type,appid,updateAt,comment, qqNumber, create_user_id, app_name, update_url, is_update) values
                  ('$url', $show, '$type', '$appid', '$createAt', '$comment', '$qqNumber', '$login_user_id', '$appName', '$updateUrl', $isUpdate)";
          // echo $sql;
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
}
