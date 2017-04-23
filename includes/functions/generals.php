<?php

function postUrlExists($link, $url){
  $num = mysqli_num_rows(mysqli_query($link, "SELECT post_id FROM posts WHERE post_name='$url' LIMIT 1"));
  return $num == 1 ? true : false;
}

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

function makeCategory($link,$category,$num){
  if(category_exists($link, $category) == false){
    if(!mysqli_query($link,"INSERT INTO categories(category_name) VALUES('$category')")){
      return false;
    }else{
      return true;
    }
  }else{
    if(!mysqli_query($link,"UPDATE categories SET category_popularity = category_popularity+$num WHERE category_name = '$category'")){
      return false;
    }else{
      return true;
    }
  }
}

function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


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
