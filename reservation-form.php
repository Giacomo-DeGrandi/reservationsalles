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
/*
$servername = 'localhost:3306';
$username = 'giditree';
$password = 'admin.io';
$database = 'carlo-de-grandi-giacomo_reservationsalles';

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'reservationsalles';*/  

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
	setcookie('id',$idcookie,time() -3600, '/reservationsalles');
	setcookie('connected',$logincookie,time() -3600, '/reservationsalles');
	session_destroy();
	header('Location: planning.php');
}

if(!isset($_COOKIE['connected'])){		//if for any weird reason the user pass here without cookies, i send him/her to log in
	header('Location: connexion.php');
}


?>	
			<form action="" method="post">
							<button class="closedit2" name="gobacktoplan">go to the planning</button>
			</form><br>
			<form action="" method="post">
							<button class="closedit2" name="gobackhome">go to the home page</button>
			</form><br>
<?php

if(isset($_POST['gobacktoplan'])){
	session_destroy();
	header('Location:planning.php');
}
if(isset($_POST['gobackhome'])){
	session_destroy();
	header('Location:index.php');
}

if(isset($_COOKIE['connected'])){
	echo '<form action="" method="post">
				<input type="submit" name="disconnect" id="disconnect" value="disconnect">
			</form>';
	echo '<form action="" method="post">
				<button class="closedit2" name="gobackaccount">go to your profile</button>
			</form><br>';

} else { 
	header('location:connexion.php');   
}

if(isset($_POST['gobackaccount'])){
	session_destroy();
	header('Location:profil.php');
}

?>
	</header>
	<main>
		<div id="reserdiv">
<div id="dateinfo3">
					<form action="" method="post">
<?php 


if(isset($_SESSION['edit'])){
	$idres=$_SESSION['edit'];
	$quest= "SELECT id, titre, description, debut FROM reservations WHERE id = '$idres'";
	$req=mysqli_query($conn,$quest);
	$res=mysqli_fetch_all($req,MYSQLI_ASSOC);
	echo '<span><h1>Edit an existing event</h1></span>';
} else {
	echo '<span><h1>Book an event</h1></span>';
}


?>
			<span><i>title</i>&#160;&#160;&#160;<i>max 30 characters</i></span>
<?php

if(isset($_SESSION['edit'])){
	$idres=$_SESSION['edit'];
	$quest= "SELECT id, titre, description, debut FROM reservations WHERE id = '$idres'";
	$req=mysqli_query($conn,$quest);
	$res=mysqli_fetch_all($req,MYSQLI_ASSOC);
	echo '<textarea rows="1" cols="20" name="title" placeholder="'.$res[0]['titre'].'" required></textarea><br>';
} else {
	echo '<textarea rows="1" cols="20" name="title" placeholder="write here the title of your message..." required></textarea><br>';
}
?>
		<span class="messagespan"><b>description </b>&#160;&#160;&#160;<i>max 500 characters</i></span>
<?php

if(isset($_SESSION['edit'])){
	$idres=$_SESSION['edit'];
	$quest= "SELECT id, titre, description, debut FROM reservations WHERE id = '$idres'";
	$req=mysqli_query($conn,$quest);
	$res=mysqli_fetch_all($req,MYSQLI_ASSOC);
	echo '<textarea rows="4" cols="40" name="descriptionform" placeholder="'.$res[0]['description'].'" required></textarea><br>';
} else {
	echo '<textarea rows="4" cols="40" name="descriptionform" placeholder="write here the description..." required></textarea><br>';
}

?>
						<span class="messagespan"><i>choose a date</i></span>
<?php

if(isset($_SESSION['edit'])){
	$idres=$_SESSION['edit'];
	$quest= "SELECT id, titre, description, debut FROM reservations WHERE id = '$idres'";
	$req=mysqli_query($conn,$quest);
	$res=mysqli_fetch_all($req,MYSQLI_ASSOC);
	$datetime=$res[0]['debut'];
	echo '<input type="date" name="dateform" value="'.substr($datetime,0,-9).'"><br>';
} elseif (isset($_SESSION['datetime'])) {
	$datetime=$_SESSION['datetime'];
	echo '<input type="date" name="dateform" value="'.substr($datetime,0,-9).'"><br>';
} else {
	echo '<input type="date" name="dateform"><br>';
}
?>

						<span class="messagespan"><b>choose a time </b>&#160;&#160;&#160;<i>*max booking 1h from 8am to 7pm</i></span>
<?php 

if(isset($_SESSION['edit'])){
	$idres=$_SESSION['edit'];
	$quest= "SELECT id, titre, description, debut FROM reservations WHERE id = '$idres'";
	$req=mysqli_query($conn,$quest);
	$res=mysqli_fetch_all($req,MYSQLI_ASSOC);
	$datetime=$res[0]['debut'];
	echo '<input type="time" name="time" value="'.substr($res[0]['debut'],11).'">';
} 	elseif(isset($_SESSION['datetime'])){
	//echo  $_SESSION['datetime'];
	$datetime=$_SESSION['datetime'];
	$pattern = '/[-]/i';
	$replacement = '/';
	$datetime= preg_replace($pattern, $replacement, $datetime);
	echo '<input type="time" name="time" value="'.substr($_SESSION['datetime'],11).'"><br>'; // add slashes to convert
}	else {
	echo '<input type="time" name="time">';
}

?>
						<span><br></span>
						<input type="submit" class="idreserveg" name="send_form" value="book"><br><br>
					</form>
						<form action="" method="post">
							<button class="closedit" name="closeedit2">close booking page</button>
						</form><br>


<?php


if(	(isset($_POST['title']) and !empty($_POST['title'])) and 
	(isset($_POST['descriptionform']) and !empty($_POST['descriptionform'])) and 
	(isset($_POST['dateform']) and !empty($_POST['dateform'])) and
	(isset($_POST['time']) and !empty($_POST['time']))	){
		$idres= $_SESSION['edit'];
		$user=$_COOKIE['id'];
		$title=mysqli_real_escape_string($conn,htmlspecialchars($_POST['title']));
		$description=mysqli_real_escape_string($conn,htmlspecialchars($_POST['descriptionform']));
		$date=$_POST['dateform'];
		if($date<date('Y-m-d H:i:s',strtotime('-1 day'))){
			echo '<span class="messagespan"><i>you can\'t book a date in the past!<br> Choose another time please.</i></span>';
		} else { 
			if(isset($_SESSION['edit'])){
				if(isset($_POST['send_form'])){ 
					$time=substr($_POST['time'],0,-3).':00';
					$debut= $date.' '.$time;
					$questdeb=" SELECT * FROM reservations WHERE debut = '$debut' ";
					$reqdeb= mysqli_query($conn,$questdeb);
					$resdeb= mysqli_fetch_row($reqdeb);
					$fin = ((int)$time + 1).':00:00';
					$fin= $date.' '.$fin;
					if(!empty($resdeb) and $resdeb[5] === $user){
						$newidres=$resdeb[0];
						$questreplace="UPDATE reservations SET titre = '$title', description='$description', debut = '$debut',fin= '$fin',id_utilisateur= '$user' WHERE id = '$newidres' ";
						$ressend= mysqli_query($conn,$questreplace);
						$questdelold="DELETE FROM reservations WHERE id = '$idres' ";
						$resdelold= mysqli_query($conn,$questdelold);
						session_destroy();
						header('location:planning.php');
					} elseif (empty($resdeb))	{
						$questformbook="UPDATE reservations SET titre = '$title', description='$description', debut = '$debut',fin= '$fin',id_utilisateur= '$user' WHERE id = '$idres' AND id_utilisateur = '$user' ";
						$ressend= mysqli_query($conn,$questformbook);
						session_destroy();
						header('location:planning.php');
					} elseif (!empty($resdeb)){
						echo '<span><i> This hour has already been booked,<br> please choose another hour</i></span>';
					}
				}
			} else  {
				if(isset($_POST['send_form'])){ 
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
								session_destroy();		
								header('location:planning.php');
						}
				}
			}
		}
} else { 
	echo '<span class="messagespan"><h7><i>*please fill in all the fields to validate the form<i><h7></span>';
}


if(isset($_POST['closeedit2'])){
	unset($_SESSION['edit']);
	header('Location:profil.php');
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