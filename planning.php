<?php
ini_set('session.cookie_lifetime', 0);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0);
ini_set('session.use_trans_sid', 0);
ini_set('session.cache_limiter', 'private_no_expire');
ini_set('session.hash_function', 'sha256');

session_start();

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'reservationsalles'; 

$conn = mysqli_connect($servername, $username, $password, $database);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Planning</title>
	<link rel="stylesheet" type="text/css" href="reservationsalles.css">
</head>
<body>
	<header>
	</header>
	<main>
		<div id="bkgtable">
<?php

$date = getdate();		// get today date
$wday = $date['weekday'];	//day of the week
$yday = $date['mday'];	//day of the month

echo '<h1>'.$wday.' '.$yday.'</h1>';

$quest=" SELECT * FROM reservations";
$req=mysqli_query($conn,$quest);
$res=mysqli_fetch_all($req,MYSQLI_ASSOC);

var_dump($res);

?>
			<table id="plantable">
				<tr>
					<th>&#160;&#160;&#160;&#160;&#160;</th>
					<th><?php   echo '<h2>'.date('l d', strtotime('-3 day')).'</h2>' ?></th>
					<th><?php   echo '<h2>'.date('l d', strtotime('-2 day')).'</h2>'  ?></th>
					<th><?php 	echo '<h2>'.date('l d', strtotime('-1 day')).'</h2>'  ?></th>
					<th><?php 	echo '<h2>'.date('l d').'</h2>' ; ?></th>		<!--  today date -->
					<th><?php 	echo '<h2>'.date('l d', strtotime('+1 day')).'</h2>'  ?></th>
					<th><?php 	echo '<h2>'.date('l d', strtotime('+2 day')).'</h2>'  ?></th>	
					<th><?php 	echo '<h2>'.date('l d', strtotime('+3 day')).'</h2>'  ?></th>
				</tr>
<?php

$date = getdate();		// get today date
$wday = $date['weekday'];	//day of the week

for($i=0;$i<=11;$i++){
	echo '<tr>';
		for($j=0 ;$j<=6;$j++){
			echo '<td>';
			if($j==0){
				echo $i+8;
			}
			echo '<form action="" method="get">';
			echo '</td>';
		}
	echo '</tr>';
}

?>
			</table>
		</div>
	</main>
	<footer>
			<p>giditree<p> 
			<a href="https://github.com/Giacomo-DeGrandi">mon github</a> 
	</footer>
</body>
</html>