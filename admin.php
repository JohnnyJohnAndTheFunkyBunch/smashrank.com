<?php
 
include('mysql.php');
include('functions.php');

$result = mysql_query("SELECT * FROM leagues WHERE name = '".$_GET['group']."'");
$league = mysql_fetch_object($result);

$correct_password = $league->password;

$pass = $_POST['pass'];
$group = $_GET['group'];

  if($pass != $correct_password){ 
  ?>
	<html>
	<head>
	<link rel="shortcut icon" href="http://www.smashrank.com/images/SmashBrosSymbol.ico">
	<title>Smash Players Database</title>
	<link href="http://www.smashrank.com/smashlayout.css" rel='stylesheet' type="text/css" title="Default">
	<link href="http://www.smashrank.com/button.css" rel='stylesheet' type="text/css" title="Default">
	</head>
	  <a href="/?group=<?echo $group?>"> Return </a>
      <h1><? echo "{$group} Admin Access"; ?></h1>
	  <form method="POST" action="admin.php?group=<?echo $group?>">
       Password <input type="password" name="pass"></input><br/>
            <input type="submit" name="submit" value="Go"></input>
      </form>
	  <? 
	  if ($pass) {
		echo "<p> Authentication Failed </p>";
	}?>
	 </html>
	  <?
      exit; 
  } 
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="http://www.smashrank.com/images/SmashBrosSymbol.ico">
<title>Smash Players Database</title>
<link href="http://www.smashrank.com/smashlayout.css" rel='stylesheet' type="text/css" title="Default">
<link href="http://www.smashrank.com/button.css" rel='stylesheet' type="text/css" title="Default">
</head>
<body>

<script language="javascript" type="text/javascript">
<!-- 
//Browser Support Code
function ajaxFunction(option){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	var winner = document.getElementById('winner').value;
	var loser = document.getElementById('loser').value;
	
	var name = document.getElementById('name').value;
	var realname = document.getElementById('realname').value;
	var main = document.getElementById('main').value;
	var location = document.getElementById('location').value;
	
	var group = '<?echo $_GET['group'];?>';
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	// Use this to adjust the display of who just won and shit
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			document.getElementById("output").innerHTML=ajaxRequest.responseText;
			// clear the form, UI better
			document.getElementById("winner").value = '';
			document.getElementById("loser").value = '';
			document.getElementById("name").value = '';
			document.getElementById("main").value = '';
			document.getElementById("realname").value = '';
			document.getElementById("location").value = '';
		}
		else if(ajaxRequest.readyState == 1){
			document.getElementById("output").innerHTML='Submitting...';
		}
	}
	
	if (option == 'battle') {
		ajaxRequest.open("POST", "battle.php", true);
		ajaxRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		ajaxRequest.send('winner='+winner+'&loser='+loser+'&group='+group); // change to variables
	}
	else {
		ajaxRequest.open("POST", "addplayer.php", true);
		ajaxRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		ajaxRequest.send('name='+name+'&realname='+realname+'&main='+main+'&location='+location+'&group='+group); // change to variables
	}
}


//-->
</script>

	<a href="/?group=<?echo $group?>"> Return </a>
	<table align="center">
		<tr>
			<td colspan="2">Enter Battle</td>
		</tr>
		<tr>
			<td>Winner:</td>
			<td><input type="text" id ="winner" name="winner"></td>
		</tr>
		<tr>
			<td>Loser:</td>
			<td> <input type="text" id="loser" name="loser"> </td>
		</tr>
	</table>
	<button class="cupid-blue" onclick="ajaxFunction('battle')" value="Enter"> Enter </button>
	<table align="center">
		<tr>
			<td colspan="2">Create New Player</td>
		</tr>
		<tr>
			<td>Name: </td>
			<td><input type="text" id="name"></td>
		</tr>
		<tr>
			<td>Real Name: </td>
			<td><input type="text" id="realname"></td>
		</tr>
		<tr>
			<td> Main: </td>
			<td> <input type="text" id="main"></td>
		</tr>
		<tr>
			<td> Location:</td>
			<td> <input type="text" id="location"> </td>
		</tr>
	</table>
	<button class="cupid-blue" onclick="ajaxFunction('player')" value="Create"> Create </button> <br>
	<br>
	<button class="cupid-blue" onclick="ajaxFunction('delete')" value="Delete"> Delete Database </button>
	<div id="output"></div>

	
<? // Add a database about activity done to database?>



</body>
</html>