<?php
 
include('mysql.php');
include('functions.php');
// if integer, use id, if string, use names, and find their id
// change battles to GROUPNAME_battles
// If rating - update the database
if ($_POST['winner'] && $_POST['loser'] && $_POST['group']) {

 $user = $_SERVER['REMOTE_ADDR'];
 if (str_replace(' ', '', strtolower($_POST['winner'])) == str_replace(' ', '',strtolower($_POST['loser']))) {
	echo '<p>Failed: '.$_POST['loser'].' duplicate name.</p>';
	goto end;
}
 
 // Get the winner
 $result = mysql_query("SELECT * FROM db_".$_POST['group']." WHERE name = '".$_POST['winner']."' ");
 $winner = mysql_fetch_object($result);
 if (!$winner) {
	echo '<p>Failed: '.$_POST['winner'].' does not exist.</p>';
	goto end;
	}
 // POST the loser
 $result = mysql_query("SELECT * FROM db_".$_POST['group']." WHERE name = '".$_POST['loser']."' ");
 $loser = mysql_fetch_object($result);
 if (!$loser) {
	echo '<p>Failed: '.$_POST['loser'].' does not exist.</p>';
	goto end;
	}
 
 // Update the winner score
 $winner_expected = expected($loser->score, $winner->score);
 $winner_new_score = win($winner->score, $winner_expected);
  //test print "Winner: ".$winner->score." - ".$winner_new_score." - ".$winner_expected."<br>";
 mysql_query("UPDATE db_".$_POST['group']." SET score = ".$winner_new_score.", wins = wins+1 WHERE player_id = ".$winner->player_id);

 // Update the loser score
 $loser_expected = expected($winner->score, $loser->score);
 $loser_new_score = loss($loser->score, $loser_expected);
  //test print "Loser: ".$loser->score." - ".$loser_new_score." - ".$loser_expected."<br>";
 mysql_query("UPDATE db_".$_POST['group']." SET score = ".$loser_new_score.", losses = losses+1  WHERE player_id = ".$loser->player_id);
 
 // Insert battle
 mysql_query("INSERT INTO battles_".$_POST['group']." SET winner = ".$_POST['winner'].", loser = ".$_POST['loser'].", user = '".$user."'");

 echo "Success";
 echo "<p>Winner: {$_POST['winner']}. Old Rating: {$winner->score}. New Rating: {$winner_new_score}</p>";
 echo "<p>Loser: {$_POST['loser']}. Old Rating: {$loser->score}. New Rating: {$loser_new_score}</p>";
 end:
}

?>