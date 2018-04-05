<?php

include 'conn.php';
include 'session.php';
include 'conn_memcached.php';

$returnData = array();
if (check_user_login_out_of_time() == false) {
  $returnData['rt_code'] = -2;
} else {
  if (isset($_GET['ids']) &&
      isset($_GET['url']) &&
      isset($_GET['show']) &&
      isset($_GET['qqNumber']) &&
      isset($_GET['imgList']) &&
      isset($_GET['marqueeContent'])) {
    $ids = $_GET['ids'];
    $ids = rtrim($ids,", ");
    $url = $_GET['url'];

    $show = $_GET['show'];

    $qqNumber = $_GET['qqNumber'];
    $imgList = $_GET['imgList'];
    $marqueeContent = $_GET['marqueeContent'];

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
    if ($imgList != '') {
        $sql .=  ", imgList = '$imgList'";
    }
    if ($marqueeContenturl != '') {
        $sql .=  ", marqueeContent = '$marqueeContent'";
    }

    $sql .= " where id in ($ids)";

    echo $sql;

    $result = mysql_query($sql);
    
    if ($result == false) {
      $returnData['rt_code'] = 0;
    } else {
      $returnData['rt_code'] = 1;
    }

    $sql_for_remove = "select * from lottery where id in ($ids)";
    $result_for_remove = mysql_query($sql_for_remove);

    echo $sql_for_remove;

    if ($result_for_remove == false) {
        $returnData['rt_code'] = 0;
    } else {
        while ($row = mysql_fetch_assoc($result_for_remove)) {
            $key=md5($row['appid']);
            $mem->delete($key);
        }
    }

  } else {
    $returnData['rt_code'] = -1;
  }
}

echo json_encode($returnData);
