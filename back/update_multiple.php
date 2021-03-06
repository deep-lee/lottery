<?php

include 'conn.php';
include 'session.php';

//判断是否为ajax请求，后端防止别人利用curl的post抓取数据  
if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])&&strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
  $returnData = array();
  if (check_user_login_out_of_time() == false) {
    $returnData['rt_code'] = -2;
  } else {
    if (isset($_GET['ids']) &&
        isset($_GET['url']) &&
        isset($_GET['show']) &&
        isset($_GET['qqNumber']) &&
        isset($_GET['isUpdate']) &&
        isset($_GET['updateUrl'])) {
  
      $ids = $_GET['ids'];
      $ids = rtrim($ids,", ");
  
      $url = $_GET['url'];
  
      $show = $_GET['show'];
  
      $qqNumber = $_GET['qqNumber'];
      $isUpdate = $_GET['isUpdate'];
      $updateUrl = $_GET['updateUrl'];
  
      date_default_timezone_set('Asia/Shanghai');
      $updateAt = date('Y-m-d H:i:s');
  
      // echo $id." ".$url." ".$appid." ".$type." ".$show." ".comment." ".$updateAt;
  
      $sql = "update lottery set updateAt = '$updateAt'";
      if ($url != '') {
          $sql .=  ", url = '$url'";
      }
      if ($show != '') {
          $sql .=  ", show_url = '$show'";
      }
      if ($qqNumber != '') {
          $sql .=  ", qqNumber = '$qqNumber'";
      }
      if ($isUpdate != '') {
          $sql .=  ", is_update = $isUpdate ";
      }
      if ($updateUrl != '') {
          $sql .=  ", update_url = '$updateUrl'";
      }
  
      $sql .= " where id in ($ids)";
  
      // echo $sql;
  
      $result = mysql_query($sql);
      
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
  
}