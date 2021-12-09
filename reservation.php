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
		<a href="planning.php" target="_top"> go to the planning </a>
	</header>
	<main>
		<table>
<?php
$_SESSION['reservation']=$_GET['id'];

echo $_SESSION['reservation'];



	//$quest=" SELECT * FROM reservations WHERE debut = '$debut' ";
	//$req=mysqli_query($conn,$quest);
	//$res=mysqli_fetch_all($req,MYSQLI_ASSOC);


?>
		</table>
	</main>
	<footer>
			<p>giditree<p> 
			<a href="https://github.com/Giacomo-DeGrandi">mon github</a> 
	</footer>
</body>
</html>