<?php
########## MySql details (Replace with yours) #############
$username = "id863376_artemip"; //mysql username
$password = "slotm"; //mysql password
$hostname = "localhost"; //hostname
$databasename = "id863376_base_one"; //databasename

$connecDB = mysql_connect($hostname, $username, $password)or die('could not connect to database');
mysql_select_db($databasename,$connecDB);
?>
