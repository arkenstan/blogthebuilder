<?php


function sanitize($link,$item){
  $item = stripslashes($item);
  $item = trim($item);
  $item = htmlspecialchars($item);
  return mysqli_real_escape_string($link, $item);
}

function get_blog_settings($link){
  $settings = array();
  $res = mysqli_query($link, "SELECT * FROM settings");
  while($row = mysqli_fetch_assoc($res)){
    $settings[$row['settings_name']] = $row['settings_value'];
  }
  return $settings;
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



?>
