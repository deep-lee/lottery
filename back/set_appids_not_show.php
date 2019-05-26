<?php

include 'conn.php';
include 'session.php';

//判断是否为ajax请求，后端防止别人利用curl的post抓取数据  
if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])&&strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
  $returnData = array();

  if (check_user_login_out_of_time() == false) {
    $returnData['rt_code'] = -2;
  } else {
    if (isset($_GET['appids'])) {
      $appids = $_GET['appids'];
      $sql = "update lottery set show_url = 0 where appid in (".$appids.")";
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

  $json = json_encode($returnData);

  echo $json;
}
