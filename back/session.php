<?php

header("Access-Control-Allow-Origin:http://www.ds06ji.com,http://www.ww88op.com,http://www.jh06ip.com,http://www.huj18m.com,http://www.hhuo2l.com");

function check_user_login_out_of_time() {
  $admin = false;
  // 启动会话，这步必不可少
  session_start();

  if(!isset($_SESSION['last_access']) || (time()-$_SESSION['last_access'])>1200)
  {
    unset($_SESSION['admin']);
  } else {
     $_SESSION['last_access'] = time();
  }

  // 判断是否登陆
  if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
      $admin = true;
  }
  return $admin;
}

//  get login user id
function get_login_user_id() {
  return $_SESSION["login_user_id"];
}

function logout() {
  unset($_SESSION['admin']);
}
