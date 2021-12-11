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
	<title>Profil</title>
	<link rel="stylesheet" type="text/css" href="reservationsalles.css">
</head>
<body>
	<header>
<?php

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
			<form action=""	method="post" >
				<input type="submit" name="disconnect" id="disconnect" value="disconnect">
			</form>
	</header>
<main>
<?php

if(isset($_COOKIE['connected']) and isset($_COOKIE['id'])){
	echo '&#160;&#160;&#160<h1>welcome &#160;&#160;&#160;'.$_COOKIE['connected'].'</h1>'; 
} else {
	header('Location: index.php');
}

?>
	<div style=" background-color: white;" id="wrapper1">
		<div style=" background-color: var(--bittered);" id="dateinfo">
			<br><br><h2>Live now from the studio:</h2>
<?php 



	$date=date('Y-m-d H:i:s');
	$date=substr($date, 0, -5);
	$date=$date.'00:00';
	$questlive= "SELECT id, titre, description, debut, id_utilisateur FROM reservations WHERE debut = '$date'";
	$req=mysqli_query($conn,$questlive);
	$res=mysqli_fetch_all($req,MYSQLI_ASSOC);

	foreach($res as $k =>$v ){
						echo '<div class="scrolldiv2pro">';
						echo '<form action="reservation.php" method="GET">';
						echo '<button type="submit" class="subid" name="id" value="'.$v['id'].'"><br/>';
						echo '<span> '.substr($v['titre'],0,10).'...';'</span><br/>';
						echo '<span> '.$v['description'].'</span>';
						echo '</button>';
						echo '</form>';
						echo '</div>';
	}


?>
		</div>
		<div style=" background-color: var(--bkgborder);" id="boxreserve">
			<table>
				<tr>
					<th> your latest bookings </th>
				</tr>
<?php 

$id=$_COOKIE['id'];
$quest= "SELECT id, titre, description, debut, id_utilisateur FROM reservations WHERE id_utilisateur = '$id'";
$req=mysqli_query($conn,$quest);
$res=mysqli_fetch_all($req,MYSQLI_ASSOC);

if(!empty($res)){
	foreach($res as $k=>$v){
		echo '<tr>';
		foreach($v as $k2 => $v2){
			if($k2 === 'id'){
				echo '<td><form action="" method="post"><button type="submit" class="edits" name="idbookingsprofile" value="'.$v2.'">&#160;edit</button></form></td>';
			} else {
				echo '<td><div class="scrolldiv">'.$v2.'&#160;&#160;&#160;&#160;</div></td>';
			}
		}
		echo '</tr>';
	}
}


?>			
			</table>
		</div>
	</div>
	<div style=" background-color: white;" id="wrapper2">
		<div style=" background-color: blue;" id="dateinfo">
			<br><br><br><br><br>send message
		</div>
		<div style=" background-color: blueviolet;" id="boxreserve">
			<br><br><br><br><br>latest messages received
		</div>
	</div>
	<div id="wrapper2">
		<div id="dateinfo2">
			<div id="dateinfo">
			<br><a href="#edithere"><h2>⚙️settings </h2></a>
			</div>
			<div style=" background-color: gray;" id="dateinfo">
				book
			</div>	
		</div>
		<div style=" background-color: orange;" id="boxreserve">
			<br><br><br><br><br>latest messages sent
		</div>
	</div>
	<div id="edithere">
		<form action="" method="post">
			<input type="text" name="username" placeholder="username"><br><br>
			<input type="password" name="password" placeholder="password"><br><br>
			<input type="submit" name="submitinfo" value="submit" class="edits">
			<a href="#">close</a>
		</form>
	</div>
<?php

if( ((isset($_POST['username']) and ($_POST['username']) != '')) and
	((isset($_POST['password']) and ($_POST['password']) != ''))  ){
	if (isset($_POST['submitinfo'])){
		$login=$_POST['username'];
		$questinfo = "SELECT login FROM utilisateurs WHERE login = '$login' ";
		$reqinfo=mysqli_query($conn,$questinfo);
		$res=mysqli_fetch_row($reqinfo);
		if(!empty($res)){
			echo 'this username already exists.<br> Please choose another username';
		}	else {
			$login2=mysqli_real_escape_string($conn,htmlspecialchars($_POST['username']));;
			$password2=password_hash(mysqli_real_escape_string($conn,htmlspecialchars($_POST['password'])), PASSWORD_BCRYPT);
			$id = $_COOKIE['id'];
			$questinfo1 = "UPDATE utilisateurs SET login = '$login2',password = '$password2'WHERE id = '$id' ";
			$reqinfo1=mysqli_query($conn,$questinfo1);
			}
	}
}

?>
</main>
	<footer>
			<p>giditree<p> 
			<a href="https://github.com/Giacomo-DeGrandi">mon github</a> 
	</footer>
</body>
</html>