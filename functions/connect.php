<?php

include 'configuration.php';

$db_conx = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_BASE);

if(!$db_conx){
	echo 'Unable to Connect to Database';
	exit(0);
}

?>
