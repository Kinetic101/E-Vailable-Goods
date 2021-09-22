<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();

	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

	$_SESSION["market"] = "";
	$_SESSION["product"] = "";
	$_SESSION["buy_arr"] = array();

	if(isset($_GET["user"])){
		$_SESSION["visit_user"] = $_GET["user"];
	}
?>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="TalkCSS.css">
	<link rel="stylesheet" type="text/css" href="OnlineCSS.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="TalkJS.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<title>Talk</title>
</head>
<body>

	<header>
		<nav>
			<ul class="links">
				<li><a href="Research.php">Buy</a></li>
				<li id="here"><a href="Talk.php"  id = "talk">Talk</a></li>
				<li><a href="Edit.php">Edit</a></li>
				<li><a href="Suggest.php">Suggest</a></li>
				<li><a href="About.php">About</a></li>
			</ul>
		</nav>
		<ul class="icons">
			<li><a href="Cart.php"><i class="fas fa-shopping-cart" id="cart"></i></a></li>
			<li><a href="Notifications.php" id="notifsss"><i class="fas fa-bell" id="bell"></i></a></li>
		</ul>
		<a href = "Research.php" class = "evg">E-Vailable Goods</a>
		<ul>
		<li class = "dropdown">
			<a href = "Profile.php" class="pic">
			<div class="prof">
				<img src = "<?php echo $_SESSION["prof_pic"]?>" alt = "Avatar" class = "dp">
			</div>
		</a>
		<div class="dlinks">
      		<a href="Profile.php">Profile</a>
      		<a href="#">Help & Support</a>
      		<a href="Logout.php">Logout</a>
    	</div>
    	</li>
		</ul>

	</header>

	<div id = "contacts"></div>

	<div id = "chatbox">
		<div id = "chat"></div>
	</div>

	<div id = "send">
		<form action = "">
			<input type = "text" name = "msg" placeholder = "Type your message here." id = "msg" />
			<button type = "button" id = "sendm">Send</button>
		</form>
	</div>

	<div id = "active"></div>   
</body>
</html>