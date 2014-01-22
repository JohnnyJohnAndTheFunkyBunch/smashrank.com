<?php
 
include('mysql.php');
include('functions.php');

// If rating - update the database
if ($_GET['winner'] && $_GET['loser']) {

 $user = $_SERVER['REMOTE_ADDR'];
 
 // Get the winner
 $result = mysql_query("SELECT * FROM smashers WHERE player_id = ".$_GET['winner']." ");
 $winner = mysql_fetch_object($result);
 
 // Get the loser
 $result = mysql_query("SELECT * FROM smashers WHERE player_id = ".$_GET['loser']." ");
 $loser = mysql_fetch_object($result);
 
 // Update the winner score
 $winner_expected = expected($loser->score, $winner->score);
 $winner_new_score = win($winner->score, $winner_expected);
  //test print "Winner: ".$winner->score." - ".$winner_new_score." - ".$winner_expected."<br>";
 mysql_query("UPDATE smashers SET score = ".$winner_new_score.", wins = wins+1 WHERE player_id = ".$_GET['winner']);
 
 // Update the loser score
 $loser_expected = expected($winner->score, $loser->score);
 $loser_new_score = loss($loser->score, $loser_expected);
  //test print "Loser: ".$loser->score." - ".$loser_new_score." - ".$loser_expected."<br>";
 mysql_query("UPDATE smashers SET score = ".$loser_new_score.", losses = losses+1  WHERE player_id = ".$_GET['loser']);
 
 // Insert battle
 mysql_query("INSERT INTO battles SET winner = ".$_GET['winner'].", loser = ".$_GET['loser'].", user = '".$user."'");
 
 // Back to the frontpage
 header('location: /');
 
}
 
?>