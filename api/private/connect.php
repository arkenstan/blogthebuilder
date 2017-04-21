<?php

$HOST = 'localhost';
$USER = 'root';
$PASS = '';
$BASE = 'blogthebuilder';

$db_conx = mysqli_connect($HOST,$USER,$PASS,$BASE);

if(!$db_conx){
  echo 'Failed to connect';
}

?>
