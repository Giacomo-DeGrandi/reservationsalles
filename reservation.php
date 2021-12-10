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
				<input type="submit" name="disconnect" value="disconnect">
			</form>
	</header>
	<main>
		<table>
<?php

$_SESSION['reservation']=$_GET['id'];

if(isset($_POST['disconnect'])){
	setcookie('connected',$login,time() -3600);
	header('Location: planning.php');
}
if(isset($_COOKIE['connected'])){
	echo 'connected';
	if(isset($_SESSION['reservation'])){
		$id=$_SESSION['reservation'];
		$quest2=" SELECT login FROM utilisateurs WHERE id = '$id' ";
		$req2=mysqli_query($conn,$quest2);
		$res2=mysqli_fetch_all($req2,MYSQLI_ASSOC);
		var_dump($res2);

	} else { echo 'no reserve id, contact support <a href="https://github.com/Giacomo-DeGrandi">here</a>';}
} else { echo '<h2>please, log in to see the event</h2>';
		 echo '<a href="connexion.php" target="_top"> Log in </a>';
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
	</main>
	<footer>
			<p>giditree<p> 
			<a href="https://github.com/Giacomo-DeGrandi">mon github</a> 
	</footer>
</body>
</html>