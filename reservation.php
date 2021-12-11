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
	<title>Reservation</title>
	<link rel="stylesheet" type="text/css" href="reservationsalles.css">
</head>
<body>
	<header>
			<a href="planning.php">go back to the planning</a> 
			<form action=""	method="post">
				<input type="submit" name="disconnect"  id="disconnect" value="disconnect">
			</form>
			<a href="profil.php" target="_top">Go to your profile</a>
	</header>
	<main class="maininsc">
		<div id="reserdiv">
			<table>
<?php

$_SESSION['reservation']=$_GET['id'];

if(isset($_POST['disconnect'])){
	$logincookie=$_COOKIE['connected'];
	$idcookie=$_COOKIE['id'];
	setcookie('id',$idcookie,time() -3600);
	setcookie('connected',$logincookie,time() -3600);
	header('Location: planning.php');
}

if(isset($_COOKIE['connected'])){
	if(isset($_SESSION['reservation'])){
		$id=$_SESSION['reservation'];
		$quest2=" SELECT * FROM reservations WHERE id = '$id' ";
		$req2=mysqli_query($conn,$quest2);
		$res2=mysqli_fetch_all($req2,MYSQLI_ASSOC);
		echo '<span class="idreserve">id reservation: '.$res2[0]['id'].'</span>';
		echo '<h1>'.$res2[0]['titre'].'</h1>';
		echo '<h3>'.$res2[0]['description'].'</h3>';
		echo '<span class="idreserve">'.'debut: '.substr($res2[0]['debut'],10).'</span>';
		echo '<span class="idreserve">'.'fin: '.substr($res2[0]['fin'],10).'</span>';

	} else { echo 'no reserve id, contact support <a href="https://github.com/Giacomo-DeGrandi">here</a>';}
} else { echo '<span>&#160;</span><h2>please, log in to see this event</h2>';
		 echo '<span>&#160;</span><a href="connexion.php" target="_top"> Log in </a><span>&#160;</span>';
}
	/*
	if(isset($_SESSION['reservation'])){
		$id=$_SESSION['reservation'];
		$quest2=" SELECT login FROM utilisateurs WHERE id = '$id' ";
		$req2=mysqli_query($conn,$quest2);
		$res2=mysqli_fetch_all($req2,MYSQLI_ASSOC);
		var_dump($res2);
	}
} else {
	echo '<h2>please log in to see the event</h2><br/>';
	echo '<a href="connexion.php" target="_top"> Log in </a>';
}*/

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