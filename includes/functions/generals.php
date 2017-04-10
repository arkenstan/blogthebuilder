<?php

function email_exists($link, $email){
  $res = mysqli_num_rows(mysqli_query($link, "SELECT user_email FROM users WHERE user_email='$email' LIMIT 1"));
  return $res == 1 ? true:false;
}

function user_data($link,$user_id){
  $res = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE user_id = $user_id LIMIT 1"));
  return $res;
}

function category_exists($link,$cate){
  $num = mysqli_num_rows(mysqli_query($link, "SELECT category_id FROM categories WHERE category_name = '$cate' LIMIT 1"));
  return $num == 1 ? true : false;
};

function logged_in(){
  return isset($_SESSION['vader'])?true:false;
}

function login($link, $user){
  $email = $user->email;
  $password = sha1($user->password);

  $res = mysqli_query($link, "SELECT user_id FROM users WHERE user_email='$email' AND user_password='$password' LIMIT 1");
  $num = mysqli_num_rows($res);
  $res = mysqli_fetch_assoc($res);
  return ($num == 1)?$res['user_id']:false;

}

function sanitize($link, $item){
  $item = trim($item);
  $item = stripslashes($item);
  $item = htmlspecialchars($item);
  return mysqli_real_escape_string($link, $item);
}

?>
