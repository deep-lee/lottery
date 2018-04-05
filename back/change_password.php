<?php

include 'conn.php';
include 'session.php';

$returnData = array();

if (check_user_login_out_of_time() == false) {
  $returnData['rt_code'] = -2;
} else {
  if (isset($_GET['newpass'])) {

    $login_user_id = get_login_user_id();
    if ($login_user_id == 1) {
      // 只有主帐号才能注册
      $newpass = $_GET['newpass'];
      $sql = "update admin set password = '$newpass' where id=$login_user_id";
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
