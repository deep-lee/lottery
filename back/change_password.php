<?php

include 'conn.php';
include 'session.php';

$returnData = array();

//判断是否为ajax请求，后端防止别人利用curl的post抓取数据  
if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])&&strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
  if (check_user_login_out_of_time() == false) {
    $returnData['rt_code'] = -2;
  } else {
    if (isset($_GET['username']) &&
        isset($_GET['newpass'])) {
  
      $login_user_id = get_login_user_id();
      if ($login_user_id == 1) {
        // 只有主帐号才能修改密码
        $username = $_GET['username'];
        $newpass = $_GET['newpass'];
        $sql = "update admin set password = '$newpass' where username='$username' ";
        $result = mysql_query($sql);
        if ($result == false) {
          $returnData['rt_code'] = 0;
        } else {
          $returnData['rt_code'] = 1;
        }
      } else {
        $returnData['rt_code'] = 3;
      }
  
      
    } else {
      $returnData['rt_code'] = -1;
    }
  }
  
  $json = json_encode($returnData);
  
  echo $json;
}
