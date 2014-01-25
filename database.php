<?php
 
include('mysql.php');

if ($_POST['password'] != $_POST['cpassword']) {
	echo '<p> Failed: Passwords do not match </p>';
	goto end;
}

$con = mysql_query("INSERT INTO leagues (name, password) VALUES ('{$_POST['name']}', '{$_POST['password']}');");

 if (!$con) {
	echo '<p> Failed: '.die (mysql_error()).'</p>';
}


 // Insert Database
 $con = mysql_query("
 
  CREATE TABLE IF NOT EXISTS `db_{$_POST['name']}` (
   `player_id` bigint(20) unsigned NOT NULL auto_increment,
   `name` varchar(255) NOT NULL UNIQUE,
   `score` int(10) unsigned NOT NULL default '1000',
   `wins` int(10) unsigned NOT NULL default '0',
   `losses` int(10) unsigned NOT NULL default '0',
   `realname` varchar(255) NOT NULL,
   `main` varchar(255) NOT NULL,
   `location` varchar(255) NOT NULL,
   CONSTRAINT pk_PlayerID PRIMARY KEY (player_id, name)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
  
 if (!$con) {
	echo '<p> Failed: '.die (mysql_error()).'</p>';
}


 $con = mysql_query("
 CREATE TABLE IF NOT EXISTS `battles_{$_POST['name']}` (
   `battle_id` bigint(20) unsigned NOT NULL auto_increment,
   `winner` bigint(20) unsigned NOT NULL,
   `loser` bigint(20) unsigned NOT NULL,
   `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
   `user` varchar(255) NOT NULL,
   PRIMARY KEY  (`battle_id`),
   KEY `winner` (`winner`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
  ");
  
if (!$con) {
	echo '<p> Failed: '.die (mysql_error()).'</p>';
}




// Add in database of database

echo "<p> Successfully added new Database: <b> {$_POST['name']} </b></p>";
echo '<a href="?group='.$_POST['name'].'"> Go to Page </a><br>';
echo '<a href="admin.php?group='.$_POST['name'].'"> Go to Admin Console </a>';

end:

?>

