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

//echo $res[0]['debut'];

?>
			<table id="plantable">
				<tr>
					<th>&#160;&#160;&#160;&#160;&#160;</th>
					<th><?php   echo '<h2>'.date('l d', strtotime('-3 day')).'</h2>' ?></th>
					<th><?php   echo '<h2>'.date('l d', strtotime('-2 day')).'</h2>'  ?></th>
					<th><?php 	echo '<h2>'.date('l d', strtotime('-1 day')).'</h2>'  ?></th>
					<th><?php 	echo '<h2><span id="today">'.date('l d').'</span></h2>' ; ?></th>		<!--  today date -->
					<th><?php 	echo '<h2>'.date('l d', strtotime('+1 day')).'</h2>'  ?></th>
					<th><?php 	echo '<h2>'.date('l d', strtotime('+2 day')).'</h2>'  ?></th>	
					<th><?php 	echo '<h2>'.date('l d', strtotime('+3 day')).'</h2>'  ?></th>
				</tr>
<?php

$date = getdate();		// get today date
$wday = $date['weekday'];	//day of the week


//function i to date to have $i formatted as H:i:s

function itoh($i){	
	$r = $i + 8;
	if($r<10){
		return '0'.$r.':'.'00'.':'.'00';
	} else {
		return $r.':'.'00'.':'.'00';
	}
}

//function j to day to have $j formatted as Y-m-d

function jtod($j){

	if($j<9){
		$j= date('Y').'-'.date('m').'-0'.$j;
		return $j;
	} else {
		$j= date('Y').'-'.date('m').'-'.$j;
	}
}

	$j=date('d');	// i assign a date to j to make it compatible and to order the column debut-fin in SQL
	$jj=ltrim($j,0);
echo $jj;


// Formatting both for SQL

function bothdh($j,$i){
	$formatdate= $j.' '.$i;
	return $formatdate;
}


//var_dump(bothdh(jtod($j),itoh($i)));

for($i=0;$i<=11;$i++){
	echo '<tr>';
		for($j=0 ;$j<=7;$j++){
			echo '<td>';
			if($j==0){
				echo $i+8;
			} else {
				echo bothdh(jtod($j),itoh($i));
				echo '<form action="" method="get">';
				if($res[0]['debut'] === (bothdh(jtod($j),itoh($i)))){
					echo 'ok';
				}
				echo '<input type="submit" value="see">';
				echo '</form>';
				echo '</td>';
			}
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