<?php

session_start();
include '../../connect.php';
include 'generals.php';

if(logged_in() == true){
  $user_id = explode("_",$_SESSION['vader']);
  $user_id = (int)$user_id[1];
  $user_data = user_data($db_conx,$user_id);
}

?>
