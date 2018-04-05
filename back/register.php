<?php

include 'conn.php';
include 'session.php';

$returnData = array();

if (check_user_login_out_of_time() == false) {
  $returnData['rt_code'] = -2;
} else {
  if (isset($_GET['username']) &&
      isset($_GET['password'])) {
        $username = $_GET['username'];
        $password = $_GET['password'];

        $login_user_id = get_login_user_id();
        if ($login_user_id == 1) {
            $sql = "insert into admin(username, password) values(
                '$username', '$password'
            )";
    
            // echo $sql;
    
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

echo json_encode($returnData);
