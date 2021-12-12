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
	<title>Profil</title>
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
			<form action=""	method="post" >
				<input type="submit" name="disconnect" id="disconnect" value="disconnect">
			</form>
	</header>
<main id="profilmain">
<?php

// WELCOME AND BUTTONS_____________________________________________________________________________________

	$loginpers=$_COOKIE['connected'];
	$questpers = "SELECT * FROM utilisateurs WHERE login = '$loginpers' ";
	$reqpers=mysqli_query($conn,$questpers);
	$respers=mysqli_fetch_row($reqpers);

if(isset($_COOKIE['connected']) and isset($_COOKIE['id'])){
	echo '&#160;&#160;&#160;<h2>welcome to your account</h2><h1>&#160;'.$respers[1].'</h1>'; 
} else {
	header('Location: index.php');
}

?>
	<div id="wrapper1">
		<div id="dateinfo2">
			<div id="dateinfo">
				<form action="" method="post">
					<button class="settingsbutton" name="settings"><h3>&#160;&#160;⚙️&#160;&#160;&#160;&#160;settings</h3></button>
				</form><br>
			</div>
			<div id="dateinfo">
				<form action="" method="post">
					<button class="settingsbutton" name="messagebutton"><h3>&#160;&#160;💬&#160;&#160;&#160;&#160;send message</h3></button>
				</form><br>
			</div>
						<div id="dateinfo">
			<form action="" method="post">
					<button class="settingsbutton" name="bookbutton"><h3>&#160;&#160;📆&#160;&#160;&#160;&#160;book an event</h3></button>
			</form><br>
			</div>
		</div>
		<div id="boxreserve">
			<table>
				<tr>
					<th> your latest bookings </th>
				</tr>
<?php

//SEND TO BOOKING FORM_______________________________________________________________________

if(isset($_POST['bookbutton'])){
	header('Location:reservation-form.php');
}

//UPDATE_____________________________________________________________________________________

if(isset($_POST['settings'])){
	echo '<div id="edithere">
				<form action="" method="post">
					<span class="messagespan"><b>your new username </b></span><br>
					<input type="text" name="username" placeholder="username"><br>
					<span class="messagespan"><b>your new password </b></span><br>
					<input type="password" name="password" placeholder="password"><br>
					<span class="messagespan"><i>update your informations </i></span><br>
					<input type="submit" name="submitinfo" value="update" class="editsgreen"><br>
				</form>
				<form action="" method="post">
					<button class="closedit" name="closeedit">close edits</button>
				</form><br>
			</div>';
}

if( ((isset($_POST['username']) and ($_POST['username']) != '')) and
	((isset($_POST['password']) and ($_POST['password']) != ''))  ){
	if (isset($_POST['submitinfo'])){
		$logininfo=$_POST['username'];
		$questinfo = "SELECT login FROM utilisateurs WHERE login = '$logininfo' ";
		$reqinfo=mysqli_query($conn,$questinfo);
		$res=mysqli_fetch_row($reqinfo);
		if(!empty($res)){
			echo '<span>this username already exists.<br> Please choose another username</span>';
		}	else {		
			$login2=mysqli_real_escape_string($conn,htmlspecialchars($_POST['username']));
			$password2=password_hash(mysqli_real_escape_string($conn,htmlspecialchars($_POST['password'])), PASSWORD_BCRYPT);
			$id = $_COOKIE['id'];
			$questinfo1 = "UPDATE utilisateurs SET login = '$login2',password = '$password2' WHERE id = '$id' ";
			$reqinfo1=mysqli_query($conn,$questinfo1);
			setcookie('connected',$login2, time() +3600);
			header("Location:profil.php");
		}
	}
}
if(isset($_POST['closeedit'])){
	$_POST['settings']=null;
}


// BOOKING TABLE_________________________________________________________________________-

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
			} elseif ($k2 === 'title'){
				echo '<td><div class="scrolldiv"><h3>'.$v2.'&#160;&#160;&#160;&#160;</h3></div></td>';
			} else {
				echo '<td><div class="scrolldiv">'.$v2.'&#160;&#160;&#160;&#160;</div></td>';
			}
		}
		echo '</tr>';
	}
}

// SEND MESSAGES__________________________________________________________

if(isset($_POST['messagebutton'])){

	echo '		<div id="dateinfo3">
					<form action="" method="post">
						<span id="messagespan1"><h2>Send message to user</h2></span>
						<span class="messagespan"><b>write here the recipient username</b></span>
						<input type="text" name="user" placeholder="name of the recipient" >
						<span class="messagespan"><b>title</b>&#160;&#160;&#160;<i>max 30 characters</i></span>
						<textarea rows="1" cols="20" name="title" placeholder="write here the title of your message..." ></textarea>
						<span class="messagespan"><b>your message </b>&#160;&#160;&#160;<i>max 500 characters</i></span>
						<textarea rows="4" cols="30" name="texttosend" placeholder="write here your message..." ></textarea><br>
						<input type="submit" class="idreserve" name="send_message" value="send"><br>
					</form>
						<form action="" method="post">
							<button class="closedit" name="closeedit2">close send message</button>
						</form><br>
				</div>';
				echo '<style> #space { display:none; } </style>';
}

if(	(isset($_POST['user']) and !empty($_POST['user'])) and 
	(isset($_POST['title']) and !empty($_POST['title'])) and 
	(isset($_POST['texttosend']) and !empty($_POST['texttosend']))	){
	if(isset($_POST['send_message'])){
		$user2=htmlspecialchars($_POST['user']);
		$user1=$_COOKIE['connected'];
		$questexi="SELECT login FROM utilisateurs WHERE login = '$user2'";
		$reqexi=mysqli_query($conn,$questexi);
		$resexi=mysqli_fetch_row($reqexi);
		if($resexi>0){
			$user2=mysqli_real_escape_string($conn,htmlspecialchars($_POST['user']));
			$title=mysqli_real_escape_string($conn,htmlspecialchars($_POST['title']));
			$text=mysqli_real_escape_string($conn,htmlspecialchars($_POST['texttosend']));
			$date=date('Y-m-d H:i:s');
			$questsend= " INSERT INTO sent  (text,user1,user2,date,title) VALUES ('$text','$user1','$user2','$date','$title') ";
			$reqsend= mysqli_query($conn,$questsend);
			echo '&#160;&#160;&#160; message sent';
			header('location:profil.php');//here i redirect the user to the same page to avoid same message on refresh
		} else {
			echo '<span class="messagespan">this user doesn\'t exists</span>';
		}
	}
}

if(isset($_POST['closeedit2'])){
	$_POST['messagebutton']=null;
}

?>			
			</table>
		</div>
	</div>
	<div id="wrapper2">
		<span id="space">
		</span>
		<div id="boxreserve2">
			<table id="receivedtable">
			<tr>
				<th>latest messages received </th>
			</tr>
<?php 

// RECEIVED TABLE____________________________________________________________________________________

$user2x=$_COOKIE['connected'];
$quest= "SELECT id, title, text, date, user1 FROM sent WHERE user2 = '$user2x'";
$req=mysqli_query($conn,$quest);
$res=mysqli_fetch_all($req,MYSQLI_ASSOC);

if(!empty($res)){
	foreach($res as $k => $v){
		echo '<tr>';
		foreach($v as $k2 => $v2){
			if($k2 === 'id'){
				// don't do anything
			} else {
			echo '<td><div class="scrolldiv">'.$v2.'</div></td>';
			}
		}
		echo '</tr>';
	}
} else {
	echo '<tr><th>There are no messages here</th><tr>';
}

?>
			</table>
		</div>
	</div> <!-- wrapper -->
	<div id="wrapper2">
		<div style=" background-color: var(--bittered);" id="dateinfo">
			<br><br><h2>Live now from the studio:</h2>
<?php 
// TODAY DATE REQUEST_________________________________________________________________________

	$date=date('Y-m-d H:i:s');
	$date=substr($date, 0, -5);
	$date=$date.'00:00';		// $date=substr(date('Y-m-d H:i:s'), 0, -5).'00:00';
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
		<span id="space">
		</span>
		<div id="boxreserve2">
			<table id="receivedtable">
			<tr>
				<th>latest messages sent </th>
			</tr>
<?php 

// SENT TABLE____________________________________________________________________________________

$user2x=$_COOKIE['connected'];
$quest= "SELECT id, title, text, date, user1 FROM sent WHERE user1 = '$user2x'";
$req=mysqli_query($conn,$quest);
$res=mysqli_fetch_all($req,MYSQLI_ASSOC);

if(!empty($res)){
	foreach($res as $k => $v){
		echo '<tr>';
		foreach($v as $k2 => $v2){
			if($k2 === 'id'){

			} else {
			echo '<td><div class="scrolldiv">'.$v2.'</div></td>';
			}
		}
		echo '</tr>';
	}
} else {
	echo '<tr><th>You haven\'t sent any message yet </th><tr>';
}

?>
			</table>
	</div>
</main>
	<footer>
			<p>giditree<p> 
			<a href="https://github.com/Giacomo-DeGrandi">mon github</a> 
	</footer>
</body>
</html>