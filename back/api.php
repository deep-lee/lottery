<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'conn.php';

if (isset($_GET["appid"])) {
  $appid = $_GET["appid"];

  $sql = "select show_url as is_wap, url as wap_url, is_update, update_url from lottery where appid='$appid'";

  $result = mysql_query($sql);

  while( $row = mysql_fetch_array($result) ){
    $data_result = $row;
  }

  // update request number

  // $sql_request_num = "select request_num from lottery WHERE appid=:appid";
  // $stmt_request_num = $dbConnection->prepare($sql_request_num);
  // $stmt_request_num->execute(array(':appid' => $appid));
  // $request_num_result = array();
  // foreach ($stmt_request_num as $row) {
  //   $request_num_result = $row;
  // }

  // $request_num = $request_num_result['request_num'];

  // $request_num = $request_num + 1;

  // $sql = "UPDATE lottery SET request_num=:request_num WHERE appid=:appid";
  // // Prepare statement
  // $stmt2 = $dbConnection->prepare($sql);
  // $stmt2->execute(array(':appid' => $appid, ':request_num' => $request_num));
  // // execute the query
  // $stmt2->execute();

  json_encode($data_result);

} else {
  $data_result = array();
  $data_result['code'] = 201;
  $data_result['msg'] = 'error';
  json_encode($data_result);
}
