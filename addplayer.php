<?php
 
include('mysql.php');


 // Insert player
 $con = mysql_query("INSERT INTO db_{$_POST['group']} (name, realname, main, location) VALUES ('{$_POST['name']}', '{$_POST['realname']}', '{$_POST['main']}', '{$_POST['location']}');");
 // Back to the frontpage
 
 if (!$con) {
	echo '<p> Failed: '.die (mysql_error()).'</p>';
}

echo "<p> Successfully added new Player: {$_POST['name']} </p>";

?>

