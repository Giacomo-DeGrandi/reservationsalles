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
	<header><br><br>
			<a href="index.php" target="_top">go to the home page </a>
			<br><br>
			<a href="inscription.php" target="_top">SIGN UP </a> 
			<br><br>
			<a href="connexion.php" target="_top">LOG IN</a>
			<br><br><br><br>
<?php

if(isset($_COOKIE['connected'])){
	echo '<form action=""	method="post" >
				<input type="submit" name="disconnect" id="disconnect" value="disconnect">
			</form>';
	echo '<a href="profil.php" target="_top">Go to your profile</a>';
} 

if(isset($_POST['disconnect'])){
	$logincookie=$_COOKIE['connected'];
	$idcookie=$_COOKIE['id'];
	setcookie('id',$idcookie,time() -3600);
	setcookie('connected',$logincookie,time() -3600);
	header('Location: planning.php');
}

?>
	</header>
	<main>
		<div id="bkgtable">
			<div id="planningtitles">
<?php

$date = getdate();		// get today date
$datetemp = $date;		// save my actual date 

// QUEST FOR DATE

echo '<h4>go to date:</h4><form action="" method="post"><input type="date" name="calendar"><input type="submit" id="searchdate" name="searchdate" value="search"></form>';

if(isset($_POST['calendar'])){
	if(isset($_POST['searchdate'])){
		//$date = $datealias; //create an alias 
		$cal= $_POST['calendar'];
		$pattern = '/[-]/i';
		$replacement = '/';
		$dayss= preg_replace($pattern, $replacement, $cal);
		$cal= $dayss.' 00:00:00';
		echo $cal.' ';
		$jdate= date('d',strtotime($cal));				//my table start values
		echo $jdate;
		$gdate= date('d',strtotime($cal.'-3 days'));
	}
} else {
	$cal= 'today';
	$jdate= date('d');
	$gdate= date('d',strtotime('-3 days'));
}

// TODAY

$wday = date('l d',strtotime($cal));	//day of the week
echo '<h1>'.$wday.'</h1>';

?>
			</div>
			<table id="plantable">
				<tr>
					<th>&#160;&#160;&#160;&#160;&#160;</th>
					<th><?php   echo '<h2>'.date('l d',strtotime($cal .'-3 days')).'</h2>' ?></th>
					<th><?php   echo '<h2>'.date('l d',strtotime($cal .'-2 days')).'</h2>'  ?></th>
					<th><?php 	echo '<h2>'.date('l d',strtotime($cal .'-1 days')).'</h2>'  ?></th>
					<th><?php 	echo '<h2><span id="today">'.date('l d',strtotime($cal)).'</span></h2>' ; ?></th>		<!--  today date -->
					<th><?php 	echo '<h2>'.date('l d',strtotime($cal .'+1 days')).'</h2>'  ?></th>
					<th><?php 	echo '<h2>'.date('l d',strtotime($cal .'+2 days')).'</h2>'  ?></th>	
					<th><?php 	echo '<h2>'.date('l d',strtotime($cal .'+3 days')).'</h2>'  ?></th>
				</tr>
<?php

//function i to date to have $i formatted as H:i:s
function itoh($i){	
	$r = $i + 8;
	if($r<=10){
		return '0'.$r.':00:00';
	} else {
		return $r.':00:00';
	}
}
//function j to day to have $j formatted as Y-m-d
function jtod($jj,$cal){
	$jj=$jj-1;
	if($jj<=9){		// if is less than 10 add a 0 on the left
		$jj= date('Y',strtotime($cal)).'-'.date('m',strtotime($cal)).'-0'.$jj;
		return $jj;
	} else {
		$jj= date('Y',strtotime($cal)).'-'.date('m',strtotime($cal)).'-'.$jj;
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
		$j=$jdate;	// NB per cambiare giorno
		$g=$gdate;
		$g=ltrim($g,0);				//alias to count
		$jj=ltrim($j,0);
		//echo $jj.' ';
		if($jj==1){
			$g=-2;
		} elseif ($jj==2){
			$g=-1;
		} elseif ($jj==3){
			$g=0;
		}
		for($jj=ltrim($j,0);$g<=$jj+4;$g++){
			echo '<td>';
			if($g==$jj-3){
				echo '&#160;&#160;&#160;';
				echo $i+8;
				echo 'h';
			} else {
				$debut=bothdh(jtod($g,$cal),itoh($i));
				$quest=" SELECT * FROM reservations WHERE debut = '$debut' ";
				$req=mysqli_query($conn,$quest);
				$res=mysqli_fetch_all($req,MYSQLI_ASSOC);
				if(!empty($res)){
					foreach($res as $k => $v){
						$id=$v['id_utilisateur'];
						$quest2=" SELECT login FROM utilisateurs WHERE id = '$id' ";
						$req2=mysqli_query($conn,$quest2);
						$res2=mysqli_fetch_all($req2,MYSQLI_ASSOC);
						echo '<div class="scrolldiv1">';
						echo '<form action="reservation.php" method="GET">';
						echo '<button type="submit" class="subid" name="idbookingsprofile" value="'.$v['id'].'"><br/>';
						echo '<span id="plantabletitles1">'.$res2[0]['login'].'</span><br/>';
						echo '<span class="plantabletitles"> '.substr($v['titre'],0,10).'...';'</span>';
						echo '<span class="plantabletitles"> '.$v['description'].'</span>';
						echo '</button>';
						echo '</form>';
						echo '</div>';

						if(isset($_GET['idbookingsprofile'])){
						$idreserve=$_GET['idbookingsprofile'];
							$_SESSION['reservation']=$_GET['idbookingsprofile'];
						}

					}
				} else {
					if(isset($_COOKIE['connected'])){
						echo '<a href="reservation-form.php">+</a>';
					} else {
						echo '<a href="connexion.php">+</a>';
					}
				}
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