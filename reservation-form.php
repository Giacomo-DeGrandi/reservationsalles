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
	echo '<form action="" method="post">
				<input type="submit" name="disconnect" id="disconnect" value="disconnect">
			</form>';
	echo '<a href="profil.php" target="_top">Go to your profile</a>';

} else { 
	header('location:connexion.php');   
}

if(isset($_SESSION['edit'])){
	
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
						<input type="date" name="dateform"><br>
						<span class="messagespan"><b>choose a time </b>&#160;&#160;&#160;<i>*max booking 1h from 8am to 7pm</i></span>
						<input type="time" name="time">
						<span><br></span>
						<input type="submit" class="idreserveg" name="send_form" value="book"><br><br>
					</form>
						<form action="" method="post">
							<button class="closedit" name="closeedit2">close booking page</button>
						</form><br>


<?php

if(!isset($_COOKIE['connected'])){
	header('Location: connexion.php');
}

if(	(isset($_POST['title']) and !empty($_POST['title'])) and 
	(isset($_POST['descriptionform']) and !empty($_POST['descriptionform'])) and 
	(isset($_POST['dateform']) and !empty($_POST['dateform'])) and
	(isset($_POST['time']) and !empty($_POST['time']))	){
	if(isset($_POST['send_form'])){ 
		$user=$_COOKIE['id'];
		$title=mysqli_real_escape_string($conn,htmlspecialchars($_POST['title']));
		$description=mysqli_real_escape_string($conn,htmlspecialchars($_POST['descriptionform']));
		$date=$_POST['dateform'];
		$time=substr($_POST['time'],0,-3).':00';
		$debut= $date.' '.$time;
		$quest=" SELECT * FROM reservations WHERE debut = '$debut' ";
		$req= mysqli_query($conn,$quest);
		$res= mysqli_fetch_row($req);
		if(!empty($res)){
			echo '<span><h4> This hour has already been booked, please choose another hour</h4></span>';
		} else {
			$fin = ((int)$time + 1).':00';
			$fin= $date.' '.$fin;
			$questformbook="INSERT INTO reservations (titre,description,debut,fin,id_utilisateur) VALUES ('$title','$description','$debut','$fin','$user')";
			$reqsend= mysqli_query($conn,$questformbook);
			header('location:planning.php');
		}
	}
}

?>
				</div>
		</div>
	</main>
	<footer>
			<p>giditree<p> 
			<a href="https://github.com/Giacomo-DeGrandi">mon github</a> 
	</footer>
</body>
</html>