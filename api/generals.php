<?php


function sanitize($link,$item){
  $item = stripslashes($item);
  $item = trim($item);
  $item = htmlspecialchars($item);
  return mysqli_real_escape_string($link, $item);
}


?>
