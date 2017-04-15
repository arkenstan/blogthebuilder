<?php

include_once 'init.php';

if(isset($_GET['act']) && !empty($_GET['act'])){
  switch((int)$_GET['act']){
    case 1:
      $ret = '';
      $num = count($user_data);
      foreach ($user_data as $key => $value) {
        $ret .= '"'.$key.'":"'.$value.'"';
        if(--$num > 0) $ret .= ',';
      }
      header('Content-type: application/json');
      echo "{ $ret }";
      break;
    case 2:
      $post = json_decode(file_get_contents('php://input'));
      $user_id = user_data['user_id'];
      $post_data = array();
      foreach ($post as $key => $value) {
        $post_data[$key] = sanitize($link, $value);
      }
      foreach ($post_data as $key => $value) {
        $value = "'$value'";
        $update[] = "$key=$value";
      }
      $update = array_implode(',', $update);
      $sql = "UPDATE users SET $update WHERE user_id = '$user_id'";
      if(!mysqli_query($db_conx, $sql)){
        echo 'Unable to connect to database';
      }else{
        $user_data = user_data($db_conx, $user_data['user_id']);
        echo 'Information Successfully Update';
      }
      break;
    case 3:
      if(isset($_POST) && !empty($_POST)){
        $pass = $_POST['password'];
        if(sha1($pass) != $user_data['password']){
          echo 'E|Current Password is wrong';
          break;
        }else{
          $newpass = $_POST['newpassword'];
          $newpass = sha1($newpass);
          $sql = "UPDATE users SET password='$newpass' WHERE user_id=".$user_data['user_id'];
          if(!mysqli_query()){
            echo 'E|Failed to Update Password';
            break;
          }else{
            echo 'S|Password Update Successfully';
          }
        }
      }
      break;
    default:
      break;
  }
}

?>
