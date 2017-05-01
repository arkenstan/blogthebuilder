<?php


/* ENTER YOUR HOSTNAME */
$HOSTNAME = 'YOUR_HOST_NAME_HERE';

/* ENTER YOU USER FOR DATABASE */
$USERNAME = 'YOUR_DATABASE_USER_HERE';

/* ENTER YOUR PASSWORD FOR DATABASE */
$PASSWORD = 'YOUR_DATABASE_PASSWORD_HERE';

/* ENTER DATABASE NAME */
$DATABASE = 'YOUR_DATABASE_NAME_HERE';

































if($HOSTNAME == 'YOUR_HOST_NAME_HERE'){
	header('Location:readme.html');
  exit(0);
}

if($USERNAME == 'YOUR_DATABASE_USER_HERE'){
	header('Location:readme.html');
  exit(0);
}

if($PASSWORD == 'YOUR_DATABASE_PASSWORD_HERE'){
	header('Location:readme.html');
  exit(0);
}

if($DATABASE == 'YOUR_DATABASE_NAME_HERE'){
	header('Location:readme.html');
  exit(0);
}

/************************************/
$db_conx = mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
if(!$db_conx){
  die("Can't connect to database");
}


?>
