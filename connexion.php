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
					//My security for session hijacking
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
<main>
	<form action="" method="post">
		<input type="text" name="login" placeholder="login" required>
		<input type="password" name="password" placeholder="password" required>
		<input type="submit" name="enter">
	</form>
<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'reservationsalles'; 

$conn = mysqli_connect($servername, $username, $password, $database);

	if(	(isset($_POST['login']) and !empty($_POST['login'])) and 
		(isset($_POST['password']) and !empty($_POST['password'])) ){ 

		$login=mysqli_real_escape_string($conn,htmlspecialchars($_POST['login']));	
		$quest = "SELECT login, password, id FROM utilisateurs WHERE login = '$login' ";
		$req=mysqli_query($conn,$quest);
		$res=mysqli_fetch_row($req);

		if($res > 0){
			if(password_verify($_POST['password'], $res[1])){

				$_SESSION['id'] = $res[2];
				$_SESSION['connected'] = $login;
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
			<a href="index.php" target="_top">go back to the home page </a>
			<br><br>
			<a href="inscription.php" target="_top">Not subscribed yet? Subscribe </a>
			<br>
		</div>
</main>
	<footer>
			<p>giditree<p> 
			<a href="https://github.com/Giacomo-DeGrandi">mon github</a> 
	</footer>
</body>
</html>