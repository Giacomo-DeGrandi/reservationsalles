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

$servername = 'localhost:3306';
$username = 'giditree';
$password = 'admin.io';
$database = 'carlo-de-grandi-giacomo_reservationsalles';


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
	setcookie('id',$idcookie,time() -3600, '/reservationsalles');
	setcookie('connected',$logincookie,time() -3600, '/reservationsalles');
	session_destroy();
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
		$cal= $_POST['calendar'];
		$jdate= date('d',strtotime($cal));				//my table start values
		$gdate= date('d',strtotime($cal.'-2 days'));
		$mdate= date('m',strtotime($cal));
	}
} else {
	$cal= 'today';
	$jdate= date('d');
	$mdate= date('m');
	$gdate= date('d',strtotime('-2 days'));
}

// TODAY

$wday = date('l d F Y',strtotime($cal));	//day of the week
echo '<h1>'.$wday.'</h1>';

?>
			</div>
			<table id="plantable">
				<tr>
					<th>&#160;&#160;&#160;&#160;&#160;</th>
					<th><?php   echo '<h2>'.date('l d',strtotime($cal .'-2 days')).'</h2>' ?></th>
					<th><?php   echo '<h2>'.date('l d',strtotime($cal .'-1 days')).'</h2>'  ?></th>
					<th><?php 	echo '<h2><span id="today">'.date('l d',strtotime($cal)).'</span></h2>' ; ?></th>		<!--  today date -->
					<th><?php 	echo '<h2>'.date('l d',strtotime($cal .'+1 days')).'</h2>'  ?></th>
					<th><?php 	echo '<h2>'.date('l d',strtotime($cal .'+2 days')).'</h2>'  ?></th>	
					<th><?php 	echo '<h2>'.date('l d',strtotime($cal .'+3 days')).'</h2>'  ?></th>
					<th><?php 	echo '<h2>'.date('l d',strtotime($cal .'+4 days')).'</h2>'  ?></th>
				</tr>
<?php



for($i=0;$i<=11;$i++){
	echo '<tr>';
	echo '<td>'.($i+8).'h</td>';
	for($j=-2;$j<=4;$j++){
		echo '<td>';
		$date=date('Y-m-d H:i:s',strtotime($cal.$j.'days'.($i+8).'hours'));
		$quest=" SELECT * FROM reservations WHERE debut = '$date' ";
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
					if(isset($_SESSION['edit'])){
					unset($_SESSION['edit']);
					}
					if(isset($_SESSION['datetime'])){
					unset($_SESSION['datetime']);
					}
				}
			}
		}else{
			if(isset($_COOKIE['connected'])){
				if($date<date('Y-m-d H:i:s')){
				} else {
					echo '<form action="" method="post">
						<button type="submit" class="closedit2" name="addreserve" value="'.$date.'"> +
						</button>
					</form>';
					if(isset($_POST['addreserve'])){		// ADD RESERVE___________________________________________
						$datey= $_POST['addreserve'];			// my coords
						$_SESSION['datetime']=$datey;
						header('location: reservation-form.php'); 
					}
				}
			} else {
				if($date<date('Y-m-d H:i:s')){
				} else {
				echo '<a href="connexion.php">+</a>';
				}
			}
		}
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