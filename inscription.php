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
					//My securities for session  hijacking 

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="reservationsalles.css">
</head>
<body>
<main class="maininsc">
	<div class="inscform">
		<h1>Subscribe</h1>
		<form action="" method="post">
			<input type="text" name="login" placeholder="login" required><br><br>
			<input type="password" name="password" placeholder="password" required><br><br>
			<input type="password" name="passwordconf" placeholder="confirm_password" required><br><br>
			<input type="submit" name="subscribe" value="subscribe">
		</form>
<?php 

$servername = 'localhost:3306';
$username = 'giditree';
$password = 'admin.io';
$database = 'carlo-de-grandi-giacomo_reservationsalles';

if(isset($_COOKIE['connected'])){
	header('location:planning.php');
}


$conn = mysqli_connect($servername, $username, $password, $database);

	if(	(isset($_POST['login']) and !empty($_POST['login'])) and 
		(isset($_POST['password']) and !empty($_POST['password'])) and 
		(isset($_POST['passwordconf']) and !empty($_POST['passwordconf'])) ){
		if($_POST['password'] === $_POST['passwordconf']){

			$login= mysqli_real_escape_string($conn,htmlspecialchars($_POST['login']));	// My security XSS et Inj SQL
			$quest= "SELECT login FROM utilisateurs WHERE login = '$login'";
			$req=mysqli_query($conn,$quest);
			$res=mysqli_fetch_row($req);
			if($res > 0){
				echo 'this username already exists';
			} else {
				$password=mysqli_real_escape_string($conn,htmlspecialchars($_POST['password']));
				$password_encrypted = password_hash($password, PASSWORD_BCRYPT);
				$quest2= " INSERT INTO utilisateurs( login, password) VALUES ('$login','$password_encrypted') ";
				$req2 = mysqli_query($conn,$quest2);
				$_SESSION['newsubscriber']=$login;

				if(isset($_POST['subscribe'])){
					header('Location: connexion.php');
				}
			}
		} else { echo 'password don\'t match'; }
	}

?>
		<div class="downlinks">
			<br><br><br><br>
			<a class="formsconnsub" href="index.php" target="_top">go to the home page </a>
			<br><br>
			<a class="formsconnsub" href="connexion.php" target="_top">Already Signed Up? Log in </a>
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