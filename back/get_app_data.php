<?php

// ini_set('display_errors', true);
// error_reporting(E_ALL);

include 'conn.php';
include 'util.php';
include 'session.php';

$returnData = array();

if (check_user_login_out_of_time() == false) {
  $returnData['rt_code'] = -2;
} else {
  $limit = $_GET['limit'];
  $offset = $_GET['offset'];
  $search_text = $_GET['search_text'];

  $login_user_id = get_login_user_id();

  // echo $limit." ".$offset." ".$search_text." ".$start_index;

  $sql = "";
  if ($search_text == '') {
    $sql = "select * from lottery";
    if ($login_user_id != 1) {
      $sql .= " where create_user_id=$login_user_id";
    }
    $sql .= " limit $offset,$limit";
  } else {
    $sql = "select * from lottery where url like '%".$search_text."%' or
            appid like '%".$search_text."%' or
            comment like '%".$search_text."%'";
    if ($login_user_id != 1) {
      $sql .= " where create_user_id='$login_user_id'";
    }

    $sql .= " limit $offset,$limit";
  }

  echo $sql;

  $result = mysql_query($sql);

  //循环从数据集取出数据
  $i = 0;
  while( $row = mysql_fetch_array($result) ){
    $rows[$i] = $row;
    $i = $i + 1;
  }

  // get total rows

  if ($search_text == '') {
    $sql_total_rows = "select count(*) as total from lottery";
    if ($login_user_id != 1) {
      $sql_total_rows .= " where create_user_id=$login_user_id";
    }
  } else {
    $sql_total_rows = "select count(*) as total from lottery
            where url like '%".$search_text."%' or
            appid like '%".$search_text."%' or
            comment like '%".$search_text."%'";
    if ($login_user_id != 1) {
      $sql_total_rows .= " where create_user_id=$login_user_id";
    }
  }

  $result_total_rows = mysql_query($sql_total_rows);
  $row_total = mysql_fetch_array($result_total_rows);

  $result = array('total' => $row_total['total'],
                  'rows' => $rows);
  $returnData['rt_data'] = $result;
  $returnData['rt_code'] = 1;
}

$json = json_encode($returnData);

echo $json;
