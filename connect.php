<?php


/* ENTER YOUR HOSTNAME */
$HOSTNAME = 'localhost';

/* ENTER YOU USER FOR DATABASE */
$USERNAME = 'root';

/* ENTER YOUR PASSWORD FOR DATABASE */
$PASSWORD = '';

/* ENTER DATABASE NAME */
$DATABASE = 'blogthebuilder';


if($HOSTNAME == 'database_host_here'){
	header('Location:readme.html');
  exit(0);
}















/************************************/
$db_conx = mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
if(!$db_conx){
  die("Can't connect to database");
}


?>
