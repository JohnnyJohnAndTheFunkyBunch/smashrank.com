<?php
// Mysql settings
$user   = "Pickle";
$password = "06923920Cool";
$database = "Sexy";
$host   = "localhost";
mysql_connect($host,$user,$password);
mysql_select_db($database) or die( "Unable to select database");
?>