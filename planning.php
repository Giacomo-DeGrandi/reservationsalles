<?php
ini_set('session.cookie_lifetime', 0);
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0);
ini_set('session.use_trans_sid', 0);
//ini_set('session.cache_limiter', 'private_no_expire');
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
			<a href="inscription.php" target="_top">SIGN UP </a> 
			<br><br>
			<a href="connexion.php" target="_top">LOG IN</a>
			<br><br>
	</header>
	<main>
		<div id="bkgtable">
<?php

$date = getdate();		// get today date
$wday = $date['weekday'];	//day of the week
$yday = $date['mday'];	//day of the month

echo '<h1>'.$wday.' '.$yday.'</h1>';


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
function jtod($jj){
	$jj=$jj-1;
	if($jj<=9){
		$jj= date('Y').'-'.date('m').'-0'.$jj;
		return $jj;
	} else {
		$jj= date('Y').'-'.date('m').'-'.$jj;
		return $jj;
	}
}
// Formatting both for SQL
function bothdh($j,$i){
	$formatdate= $j.' '.$i;
	return $formatdate;
}
//var_dump(bothdh(jtod($g),itoh($i)));



for($i=0;$i<=11;$i++){
	echo '<tr>';
		$j=date('d');	// NB per cambiare settimana
		$g=date('d', strtotime('-3 day'));
		$g=ltrim($g,0);				//alias to count
		for($jj=ltrim($j,0);$g<=$jj+4;$g++){
			echo '<td>';
			if($g==$jj-3){
				echo $i+8;
			} else {
				$debut=bothdh(jtod($g),itoh($i));
				$quest=" SELECT * FROM reservations WHERE debut = '$debut' ";
				$req=mysqli_query($conn,$quest);
				$res=mysqli_fetch_all($req,MYSQLI_ASSOC);
				foreach($res as $k => $v){
					$id=$v['id_utilisateur'];
					$quest2=" SELECT login FROM utilisateurs WHERE id = '$id' ";
					$req2=mysqli_query($conn,$quest2);
					$res2=mysqli_fetch_all($req2,MYSQLI_ASSOC);
					echo '<form action="reservation.php" method="GET">';
					echo '<span class="plantabletitles"> '.$res2[0]['login'].'</span>';
					echo '<input type="submit" name="id" value="'.$v['id'].'"><br/>';
					echo '<span class="plantabletitles"> '.$v['titre'].'</span>';
					echo '<span class="plantabletitles"> '.$v['description'].'</span>';
					echo '</form>';
				}
				echo '</td>';
			}
		}
	echo '</tr>';
}

if(isset($_GET['id'])){
	$_SESSION['reservation']=$_GET['id'];
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