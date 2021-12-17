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
	<title>Reservation</title>
	<link rel="stylesheet" type="text/css" href="reservationsalles.css">
</head>
<body>
	<header>
			<a href="planning.php">go back to the planning</a> 
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
		<div id="reserdiv">
<?php

$_SESSION['reservation']=$_GET['idbookingsprofile'];

if(isset($_POST['disconnect'])){
	$logincookie=$_COOKIE['connected'];
	$idcookie=$_COOKIE['id'];
	setcookie('id',$idcookie,time() -3600, '/reservationsalles');
	setcookie('connected',$logincookie,time() -3600, '/reservationsalles');
	session_destroy();
	header('Location: planning.php');
}


if(isset($_COOKIE['connected'])){
	if(isset($_SESSION['reservation'])){
		$idres=$_SESSION['reservation'];
		$quest2=" SELECT * FROM reservations WHERE id = '$idres' ";
		$req2=mysqli_query($conn,$quest2);
		$res2=mysqli_fetch_all($req2,MYSQLI_ASSOC);
		$iduser=$res2[0]['id_utilisateur'];
		$quest3=" SELECT login FROM utilisateurs WHERE id = '$iduser' ";
		$req3=mysqli_query($conn,$quest3);
		$res3=mysqli_fetch_row($req3);
		echo '<span id="usertitle"><h2>'.$res3[0].'</h2></span>';
		echo '<span><h1>'.$res2[0]['titre'].'</h1></span>';
		echo '<span><h3>'.$res2[0]['description'].'</span></h3>';
		echo '<span class="idreserve">'.'<i>debut: '.substr($res2[0]['debut'],10).'</i></span>';
		echo '<span class="idreserve">'.'<i>fin: '.substr($res2[0]['fin'],10).'</i></span>';
		if($res2[0]['id_utilisateur']===$_COOKIE['id']){
		echo '	<div id="wrapdel"><form action="" method="post">
					<button type="submit" class="edits2" name="edit" value="'.$idres.'"><b>edit &#160;</b></button>
				</form>';
				if(isset($_POST['edit'])){
					$_SESSION['edit']=$_POST['edit'];
					$_SESSION['datetime']=$res2[0]['debut'];
					header('Location: reservation-form.php');
				}
		echo '	<form action="" method="post">
					<button type="submit" class="delete" name="delete" value="'.$idres.'"><b>delete &#160;</b></button>
				</form></div>';
				if(isset($_POST['delete'])){
					$idres=$_POST['delete'];
					echo $idres;
					$quest="DELETE FROM reservations WHERE id = '$idres' ";
					$req=mysqli_query($conn,$quest);
					header('location: reservation.php');
				}

		} else {
			echo '<a href="profil.php"><i>send a message to user</i></a>';
		}

	} else { 	header('location:planning.php');	// DELETED
	}
} else { echo '<span>&#160;</span><h2>please, log in to see this event</h2>';
		 echo '<span>&#160;</span><a href="connexion.php" target="_top"> Log in </a><span>&#160;</span>';
}

?>
		</div>
	</main>
	<footer>
			<p>giditree<p> 
			<a href="https://github.com/Giacomo-DeGrandi">mon github</a> 
	</footer>
</body>
</html>