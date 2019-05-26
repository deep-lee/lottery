<?php
header('Content-type:text/html; charset=gbk');
error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'conn.php';
include 'My.php';

if (isset($_GET["app_id"])) {
  $appid = $_GET["app_id"];
  
  $sql = "select show_url as is_wap, url as wap_url, is_update, update_url from lottery where appid='$appid'";

  // echo $sql;

  $result = mysql_query($sql);

  if ($result == false) {
    $data_result['code'] = 201;
    $data_result['msg'] = 'mysql error';
  } else {
    if (mysql_num_rows($result) == 0) {
      // no data found
      $data_result['code'] = 201;
      $data_result['msg'] = 'no data found';
    } else {
      while( $row = mysql_fetch_assoc($result) ){
        $data_result = $row;
        $data_result['code'] = 200;
        $data_result['msg'] = '';
      }

      // update request number

      $sql_request_num = "select request_num from lottery WHERE appid='$appid'";

      $result_request_num = mysql_query($sql_request_num);
      if ($result_request_num != false) {
        while( $row = mysql_fetch_assoc($result_request_num) ){
          $request_num_result = $row;
        }
        $request_num = $request_num_result['request_num'];
        $request_num = $request_num + 1;

        $sql_update_request_num = "UPDATE lottery SET request_num=$request_num WHERE appid='$appid'";
        $result_update_request_num = mysql_query($sql_update_request_num);
      }
    }
  }

  MySuccess4($data_result);

} else {
  $data_result = array();
  $data_result['code'] = 201;
  $data_result['msg'] = 'error';
  echo json_encode($data_result);
}
