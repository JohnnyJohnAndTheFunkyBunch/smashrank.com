<?php
/*
 * Performance rating = [(Total of opponents' ratings + 400 * (Wins - Losses)) / score].
 */
include('mysql.php');
include('functions.php');

if ($_GET['group']) {
	$group = $_GET['group'];
}
else {
	$group = 'main';
}

if ($_GET['page']) {
	$page = $_GET['page'];
}
else {
	$page = 1;
}

$startpage = ($page - 1) * 20;
$rowsperpage = 20;
 
// Get random 2
$query="SELECT * FROM db_{$group} ORDER BY RAND() LIMIT 0,2";
$result = mysql_query($query);
while($row = mysql_fetch_object($result)) {
 $smashers[] = (object) $row;
}
 
// Get the top10
$result = mysql_query("SELECT *, ROUND(score) AS performance FROM db_{$group} ORDER BY ROUND(score) DESC LIMIT {$startpage},{$rowsperpage}");
while($row = mysql_fetch_object($result)) $top_ratings[] = (object) $row;

// Get total rows
$query="SELECT COUNT(player_id) FROM db_{$group}";
$result = mysql_query($query);
$totalrows = mysql_fetch_array($result);
$total = $totalrows[0];
 
// Get list of databases
$result = mysql_query("SELECT * FROM leagues");
while($row = mysql_fetch_object($result)) $list_database[] = (object) $row;

// Close the connection
mysql_close();
 
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="http://www.smashrank.com/images/SmashBrosSymbol.ico">
<title>Smash Players Database</title>
<link href="http://www.smashrank.com/smashlayout.css" rel='stylesheet' type="text/css" title="Default">
<link href="http://www.smashrank.com/button.css" rel='stylesheet' type="text/css" title="Default">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>

<script>
$(document).ready(function(){
  $("#filter").toggle();
  $("#database").toggle();
  $("#databaselist").toggle();
  $("#filterbutton").click(function(){
    $("#filter").toggle()
   });
  $("#databasebutton").click(function(){
    $("#database").toggle();
  });
  $("#dblistbutton").click(function(){
    $("#databaselist").toggle();
  });
});

function ajaxFunction(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	var name = document.getElementById('name').value;
	var password = document.getElementById('password').value;
	
	var cpassword = document.getElementById('cpassword').value;
	
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
		}
		else if(ajaxRequest.readyState == 1){
			document.getElementById("output").innerHTML='Submitting...';
		}
	}
	
	ajaxRequest.open("POST", "database.php", true);
	ajaxRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajaxRequest.send('name='+name+'&password='+password+'&cpassword='+cpassword); // change to variables
}


</script>
</head>
<body>
<a href="/"><img src="http://www.smashrank.com/images/banner.png"></a>
<div id="middleContainer" class="box">
<table width="800">
	<tr>
		
		<td><button class="cupid-blue" id="filterbutton">Show/Hide Filter</button></td>
		<td><button class="cupid-blue" id="dblistbutton">Show Databases</button></td>
		<td>
		<?
			if ($group == 'main') {
			echo
			'<button class="cupid-blue" id="databasebutton">Create Database</button>';
			}
			else {
			echo
			'<button class="cupid-blue" id="filterbutton" onclick="location.href=\'admin.php?group='.$group.'\'">Admin</button>';
			}
		?>
		</td>
	</tr>
</table>
<div id="database">
	<p> Create New Database </p>
	<table align="center">
		<tr>
			<td align="left">Name:</td>
			<td> <input type="text" id="name"><br></td>
		</tr>
		<tr>
			<td align="left">Password:</td>
			<td><input type="password" id="password"><br></td>
		</tr>
		<tr>
			<td align="left">Confirm Password: </td>
			<td><input type="password" id="cpassword"><br></td>
		</tr>
	</table>
	<button class="cupid-blue" onclick="ajaxFunction()" value="Create" colspan="2" align="center"> Create </button>
	<div id="output"></div>
</div>

<div id="databaselist">
	<p> List of Databases </p>
	<table align="center">
		<? foreach($list_database as $key => $db) : ?>
			<tr>
				<td> <a href="?group=<?echo $db->name;?>"><?echo $db->name;?></a> </td>
			</tr>
		
		
		
		<? endforeach ?>
	
	</table>
</div>


<table width="900" id="filter" style="table-layout:fixed;">
	<tr>
		<td colspan="10" style="text-align:center;"> Rating</td>
	</tr>
	<tr>
		<td>Min: </td>
		<td colspan="2"> <input type="text" id="rate_min"></td>
		<td>Max: </td>
		<td colspan="2"><input type="text" id="rate_max"></td>
	</tr>
	<tr>
		<td colspan="10" style="text-align:center;"> Main <td>
	</tr>
	
	<tr>
		<td><input type="checkbox" name="check_list[]" value="sydney">Fox</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Falco</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Puff</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Sheik</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Marth</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Peach</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">C.Falcon</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Ice Climbers</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Dr.Mario</td>
	</tr>

	<tr>
		<td><input type="checkbox" name="check_list[]" value="sydney">Ganon</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Samus</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Pikachu</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Mario</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Luigi</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">DK</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Link</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Young Link</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Zelda</td>
	</tr>
	
	<tr>
		<td><input type="checkbox" name="check_list[]" value="sydney">Roy</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Mewtwo</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Yoshi</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Mr.G&W</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Ness</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Bowser</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Kirby</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Pichu</td>
	</tr>

	<tr>
		<td colspan="10" style="text-align:center;"> Location <td>
	</tr>
	
	<tr>
		<td><input type="checkbox" name="check_list[]" value="sydney">West Coast</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">East Coast</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Ontario</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Quebec</td>
		<td><input type="checkbox" name="check_list[]" value="sydney">Other</td>
	</tr>
	
</table>
</div>
<div id="middleContainer" class="box">
<?
if ($group == 'main') {
	echo'

	<center>
		<table class="bg box" style="position:fixed;right:20px;bottom:20px;z-index:2;padding:5px;">
		<tr>
		<td colspan="2" style="text-align:center;"> Who wins? <td>
		</tr>
		 <tr>
		  <td style="text-align:center;" valign="top" class="image"><a href="rate.php?winner=' .$smashers[0]->player_id .'&loser='.$smashers[1]->player_id.'">'.$smashers[0]->name.'</a></td>
		  <td style="text-align:center;" valign="top" class="image"><a href="rate.php?winner=' .$smashers[1]->player_id .'&loser='.$smashers[0]->player_id.'">'.$smashers[1]->name.'</a></td>
		 </tr>
		 <tr>
		  <td>Rating: '.$smashers[0]->score.'</td>
		  <td>Rating: '.$smashers[1]->score.'</td>
		 </tr>
		 <tr>
		  <td style="text-align:center;">'.round(expected($smashers[1]->score, $smashers[0]->score) * 100, 0).'%</td>
		  <td style="text-align:center;">'.round(expected($smashers[0]->score, $smashers[1]->score) * 100, 0).'%</td>
		 </tr>
		</table>
	</center>
	';
}
?>

<center>
<div id="ctitle"><?=ucwords($group) ?> Database</div>
<table id="hor-minimalist-b" summary="Employee Pay Sheet">
	<thead>
		<tr>
			<th scope="col">Rank</th>
			<th scope="col">Smasher</th>
			<th scope="col">Real Name</th>
			<th scope="col">Mains</th>
			<th scope="col">Location</th>
			<th scope="col">Rating</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i = (($page - 1) * 20);
	?>
	<? foreach($top_ratings as $key => $player) : ?>
		<? $i = $i + 1; ?>
		<? $char = $player->main;
		$char = preg_replace('~[^\p{L}\p{N}]++~u', '', $char);
		?>
		
		<tr>
			<td> <?=$i?> </td>
			<td>
				<img src="http://www.smashrank.com/images/<?=$char?>HeadSSBM.png"></img>
				<a style="padding-left: 10px" href="http://www.ssbwiki.com/Smasher:<?=$player->name?>"><?=$player->name?></a>
			</td>
			<td><?=$player->realname?></td>
			<td></td>
			<td><?=$player->location?></td>
			<td><?=$player->score?></td>
		</tr>
	<? endforeach ?>
	</tbody>
</table>
<ul class="comicNav">
<? 
if ($page != 1) {
	echo '<li><a href="?group='.$group.'">|&lt;</a></li>';
	echo '<li><a rel="prev" href="?group='.$group.'&page='.($page - 1).'">&lt; Prev</a></li>';
}
if ($total > $page * 20) {
	echo '<li><a rel="next" href="?group='.$group.'&page='.($page + 1).'">Next &gt;</a></li>';
	echo '<li><a href="?group='.$group.'&page='.ceil($total / 20).'">&gt;|</a></li>';
}
?>
</ul>

</center>

</div>
 
</body>
</html>