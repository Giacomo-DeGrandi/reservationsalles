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
					//My securities for session hijacking  

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="reservationsalles.css">
</head>
<body>
	<header>
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
	<main id='index'>	
		<div id="indextitles">
			<h1> Hi! Welcome to RoomPlan</h1><br>
			<br>
			<br>
			<a href="inscription.php" target="_top">SIGN UP </a> 
			<br><br>
			<a href="connexion.php" target="_top">LOG IN</a>
			<br><br>
			<a href="planning.php" target="_top"> go to the planning </a>
			<br><br><br><br>
		</div>
		<div id="indextablediv">
			<h1>Today planning</h1>
<?php 

$servername = 'localhost:3306';
$username = 'giditree';
$password = 'admin.io';
$database = 'carlo-de-grandi-giacomo_reservationsalles';

$conn = mysqli_connect($servername, $username, $password, $database);


// TODAY DATE REQUEST_________________________________________________________________________ 

	$date=date('Y-m-d H:i:s');
	$date=substr($date, 0, -5);
	$date=$date.'00:00';		// $date=substr(date('Y-m-d H:i:s'), 0, -5).'00:00';
	$questlive= "SELECT id, titre, description, debut, id_utilisateur FROM reservations WHERE debut = '$date'";
	$req=mysqli_query($conn,$questlive);
	$res=mysqli_fetch_all($req,MYSQLI_ASSOC);

	foreach($res as $k =>$v ){
						echo '<div class="scrolldiv2pro">';
						echo '<form action="reservation.php" method="GET">';
						echo '<button type="submit" class="subid" name="id" value="'.$v['id'].'"><br/>';
						echo '<span> '.substr($v['titre'],0,10).'...';'</span><br/>';
						echo '<span> '.$v['description'].'</span>';
						echo '</button>';
						echo '</form>';
						echo '</div>';
	}

// today table
echo '<table id="todaytable">';

	for($i=0;$i<=11;$i++){
		echo '<tr>';
		$date2=date('Y-m-d H:i:s');
		$date2=substr($date2, 0, -9);
		$date2=$date2.' 0'.($i+8).':00:00';
		$questlive2= "SELECT * FROM reservations WHERE debut = '$date2'";
		$req2= mysqli_query($conn,$questlive2);
		$res2= mysqli_fetch_all($req2,MYSQLI_ASSOC);
		echo '<td><h4>'.($i+8).'h</h4></td>';
		if(!empty($res2)){
		echo '<td><h2>'.$res2[0]['titre'].'</h2></td>';	
		echo '</tr>';	
		} else {
		echo '<td><a href="planning.php">book</a></td>';
		echo '</tr>';
		}
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