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
//	My security for session hijacking
//	 GET my session var to display reservation 
if(isset($_GET['id'])){	
	$_SESSION['reservation']=$_GET['id'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Connexion</title>
	<link rel="stylesheet" type="text/css" href="reservationsalles.css">
</head>
<body>
<header>
<?php 

	if(isset($_COOKIE['connected'])){
	echo 	'<form action=""	method="post" >
				<input type="submit" name="disconnect" id="disconnect" value="disconnect">
			</form>';
	echo '<a href="profil.php" target="_top">Go to your profile</a>';
}
?>
</header>
<main class="maininsc">
	<div class="inscform">
	<h1>Log In</h1>
		<form action="" method="post">
			<input type="text" name="login" placeholder="login" required><br><br>
			<input type="password" name="password" placeholder="password" required><br><br>
			<input type="submit" name="enter" value="enter">
		</form>
<?php

$servername = 'localhost:3306';
$username = 'giditree';
$password = 'admin.io';
$database = 'carlo-de-grandi-giacomo_reservationsalles';

$conn = mysqli_connect($servername, $username, $password, $database);

	if(	(isset($_POST['login']) and !empty($_POST['login'])) and 
		(isset($_POST['password']) and !empty($_POST['password'])) ){ 

		$login=mysqli_real_escape_string($conn,htmlspecialchars($_POST['login']));	
		$quest = "SELECT login, password, id FROM utilisateurs WHERE login = '$login' ";
		$req=mysqli_query($conn,$quest);
		$res=mysqli_fetch_row($req);

		if($res > 0){
			if(password_verify($_POST['password'], $res[1])){

				$id = $res[2];
				setcookie('id',$id ,time() +3600);
				setcookie('connected',$login ,time() +3600);
				header("Location: profil.php");

			} else { echo 'wrong password'; }
		} else { echo 'wrong username'; }
	}

	if(isset($_SESSION['newsubscriber'])){
		echo 'Hi! '.$_SESSION['newsubscriber'].' please enter your details to connect';
	}
?>

		<div class="downlinks">
			<br><br><br><br><br>
			<a class="formsconnsub" href="index.php" target="_top">go to the home page </a>
			<br><br>
			<a class="formsconnsub" href="inscription.php" target="_top">Not subscribed yet? Subscribe </a>
			<br><br>
			<a class="formsconnsub" href="planning.php" target="_top"> go to the planning </a>
			<br><br>
		</div>
	</div>
</main>
	<footer>
			<p>giditree<p> 
			<a href="https://github.com/Giacomo-DeGrandi">mon github</a> 
	</footer>
</body>
</html>