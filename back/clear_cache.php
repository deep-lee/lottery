<?php

include 'conn.php';
include 'session.php';
include 'conn_memcached.php';

$returnData = array();
if (check_user_login_out_of_time() == false) {
  $returnData['rt_code'] = -2;
} else {
  if (isset($_GET['appids'])) {
      $appids = $_GET['appids'];
      if ($appids === NULL) {
        // clear all cache
        $mem->flush();
      } else {
        $appid_array = explode(',', $appids);
        foreach ($appid_array as $appid) {
          $key=md5($appid);
          $mem->delete($key);
        }
      }
      $returnData['rt_code'] = 1;
  } else {
    $returnData['rt_code'] = -1;
  }
}

echo json_encode($returnData);