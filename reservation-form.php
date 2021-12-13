<?php

ini_set('session.cookie_lifetime', 0);		//Spécifie la durée de vie du cookie en secondes. La valeur de 0 signifie : "Jusqu'à ce que le navigateur soit éteint". La valeur par défaut est : 0 
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
	<title>Formulaire de reservation</title>
	<link rel="stylesheet" type="text/css" href="reservationsalles.css">
</head>
<body>
	<header>
<?php

//DISCONNECT______________________________________________________________________________

if(isset($_POST['disconnect'])){
	$logincookie=$_COOKIE['connected'];
	$idcookie=$_COOKIE['id'];
	setcookie('id',$idcookie,time() -3600);
	setcookie('connected',$logincookie,time() -3600);
	header('Location: planning.php');
}
?>	
			<a href="planning.php" target="_top"> go to the planning </a><br><br>
			<a href="index.php" target="_top">go back to the home page </a><br><br>
<?php
if(isset($_COOKIE['connected'])){
	echo '<form action=""	method="post" >
				<input type="submit" name="disconnect" id="disconnect" value="disconnect">
			</form>';
	echo '<a href="profil.php" target="_top">Go to your profile</a>';

}
?>
	</header>
	<main>
		<div id="reserdiv">
				<div id="dateinfo3">
					<form action="" method="post">
						<span><h1>Book an event</h1></span>
						<span><i>title</i>&#160;&#160;&#160;<i>max 30 characters</i></span>
						<textarea rows="1" cols="20" name="title" placeholder="write here the title of your message..." ></textarea><br>
						<span class="messagespan"><b>description </b>&#160;&#160;&#160;<i>max 500 characters</i></span>
						<textarea rows="4" cols="40" name="descriptionform" placeholder="write here the description..." ></textarea><br>
						<span class="messagespan"><i>choose a date</i></span>
						<input type="date"><br>
						<span class="messagespan"><b>description </b>&#160;&#160;&#160;<i>max 500 characters</i></span><br>
						<input type="submit" class="idreserve" name="send_message" value="book"><br><br>
					</form>
						<form action="" method="post">
							<button class="closedit" name="closeedit2">close booking page</button>
						</form><br>
				</div>
		</div>
	</main>
	<footer>
			<p>giditree<p> 
			<a href="https://github.com/Giacomo-DeGrandi">mon github</a> 
	</footer>
</body>
</html>