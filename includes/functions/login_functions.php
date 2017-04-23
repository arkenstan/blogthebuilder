<?php

include_once 'init.php';

if(isset($_GET['act']) && !empty($_GET['act'])){
  switch((int)$_GET['act']){
    case 1:
      $user = json_decode(file_get_contents('php://input'));
      $error = "";
      foreach ($user as $key => $value) {
        $user->$key = sanitize($db_conx, $value);
      }
      if(email_exists($db_conx, $user->email) == false){
        $error .= "Email doesn't exists|";
      }else if(empty($error)){
        $login = login($db_conx, $user);
        if($login == false){
          $error .= "Password is wrong|";
        }else{
          $_SESSION['vader'] = uniqid("btb_$login-_");
          date_default_timezone_set('UTC');
          $time = date('y-m-d H:i:s');
          $ip = getUserIP();
          mysqli_query($db_conx, "INSERT INTO activity(activity_ip,activity_type,activity_to,activity_from,activity_time) VALUES('$ip','workspace','0','0','$time')");
        }
      }

      if($error != "") echo 'E|'.$error;
      else echo 'S|'.$_SESSION['vader'];
      break;

    case 2:
      if(logged_in() == true){
        echo 'authenticated';
      }else{
        echo 'unauthenticated';
      }
      break;

  }
}else{

}

?>
