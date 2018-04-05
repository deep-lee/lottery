<?php

include 'conn.php';

$returnData = array();

if (isset($_GET['username']) &&
    isset($_GET['password'])) {
    $username = $_GET['username'];
    $password = $_GET['password'];

    $sql = "select * from admin where username = '$username' and password = '$password'";

    // echo $sql;

    $result = mysql_query($sql);
    if ($result == false) {
      $returnData['rt_code'] = 0;
    } else {
      if (mysql_num_rows($result) == 0) {
        $returnData['rt_code'] = 2;
      } else {

        $row = mysql_fetch_row($result);
        echo $row['id'];

        session_start();
        $_SESSION["admin"] = true;
        $_SESSION["login_user_id"] = $row['id'];
        $_SESSION['last_access'] = time();
        $returnData['rt_code'] = 1;
      }
    }
} else {
  $returnData['rt_code'] = -1;
}

echo json_encode($returnData);
