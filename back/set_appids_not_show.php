<?php

include 'conn.php';
include 'session.php';

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
