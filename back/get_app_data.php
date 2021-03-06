<?php

// ini_set('display_errors', true);
// error_reporting(E_ALL);

include 'conn.php';
include 'util.php';
include 'session.php';

//判断是否为ajax请求，后端防止别人利用curl的post抓取数据  
if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])&&strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
  $returnData = array();

  if (check_user_login_out_of_time() == false) {
    $returnData['rt_code'] = -2;
  } else {
    $limit = $_GET['limit'];
    $offset = $_GET['offset'];
    $search_text = $_GET['search_text'];
    
    $search_type = $_GET['search_type'];
  
    $login_user_id = get_login_user_id();
  
    // echo $limit." ".$offset." ".$search_text." ".$start_index;
  
    $sql = "";
  
    if ($search_text == '') {
      $sql = "select l.*, a.username from lottery l 
                left join admin a on l.create_user_id=a.id";
        if ($login_user_id != 1) {
          $sql .= " where create_user_id=$login_user_id order by createAt";
        } else {
          $sql .= " order by createAt";
        }
        $sql .= " limit $offset,$limit";
    } else {
      if($search_type == 0) {
        $sql = "select l.*, a.username from lottery l 
                left join admin a on l.create_user_id=a.id 
                where (url like '%".$search_text."%' or
                qqNumber like '%".$search_text."%' or
                app_name like '%".$search_text."%' or
                appid like '%".$search_text."%' or
                comment like '%".$search_text."%' ";
        if ($login_user_id != 1) {
          $sql .= ")";
          $sql .= " and create_user_id='$login_user_id' order by createAt";
        } else {
          $sql .= " or a.username like '%".$search_text."%') order by createAt";
        }
    
        $sql .= " limit $offset,$limit";
      } elseif ($search_type == 1) {
        $sql = "select l.*, a.username from lottery l 
                left join admin a on l.create_user_id=a.id 
                where appid = '$search_text' ";
        if ($login_user_id != 1) {
          $sql .= " and create_user_id='$login_user_id' order by createAt";
        } else {
          $sql .= " order by createAt";
        }
    
        $sql .= " limit $offset,$limit";
      } elseif($search_type == 2) {
        $sql = "select l.*, a.username from lottery l 
                left join admin a on l.create_user_id=a.id 
                where a.username = '$search_text' ";
        if ($login_user_id != 1) {
          $sql .= " and create_user_id='$login_user_id' order by createAt";
        } else {
          $sql .= " order by createAt";
        }
    
        $sql .= " limit $offset,$limit";
      }
    }
  
    // echo $sql;
  
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
  
      if($search_type == 0) {
        $sql_total_rows = "select count(*) as total from lottery l
              left join admin a on l.create_user_id=a.id 
              where (url like '%".$search_text."%' or
              appid like '%".$search_text."%' or
              qqNumber like '%".$search_text."%' or
              app_name like '%".$search_text."%' or
              appid like '%".$search_text."%' or
              comment like '%".$search_text."%'";
        if ($login_user_id != 1) {
          $sql_total_rows .= ")";
          $sql_total_rows .= " and create_user_id=$login_user_id";
        } else {
          $sql_total_rows .= " or a.username like '%".$search_text."%')";
        }
      } elseif($search_type == 1) {
        $sql_total_rows = "select count(*) as total from lottery l
              left join admin a on l.create_user_id=a.id 
              where appid='$search_text' ";
        if ($login_user_id != 1) {
          $sql_total_rows .= " and create_user_id=$login_user_id";
        }
      } elseif($search_type == 2) {
        $sql_total_rows = "select count(*) as total from lottery l
              left join admin a on l.create_user_id=a.id 
              where a.username='$search_text' ";
        if ($login_user_id != 1) {
          $sql_total_rows .= " and create_user_id=$login_user_id";
        }
      }
    }
  
    // echo $sql_total_rows;
  
    $result_total_rows = mysql_query($sql_total_rows);
    $row_total = mysql_fetch_array($result_total_rows);
  
    $result = array('total' => $row_total['total'],
                    'rows' => $rows);
    $returnData['rt_data'] = $result;
    $returnData['rt_code'] = 1;
  }
  
  $json = json_encode($returnData);
  
  echo $json;
}
