<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ""){
		header("Location: SignUp.php");
	}

	if($_SESSION["visit_user"] == ""){
		header("Location: Research.php");
	}

	$_SESSION["market"] = "";
	$_SESSION["product"] = "";
	$_SESSION["buy_arr"] = array();

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="Visit_UserCSS.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<title><?php echo $_SESSION["visit_user"];?></title>
</head>
<body>
	<header>
		<nav>
			<ul class="links">
				<li><a href="Research.php">Buy</a></li>
				<li><a href="Talk.php">Talk</a></li>
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
		<li class = "dropdown"><a href = "Profile.php" class="pic">
			<div class="prof"><img src = "abstract-art-artistic-1020315.jpg" alt = "Avatar" class = "dp">
			</div>
		</a>
		<div class="dlinks">
      			<a href="Profile.php" id = "press">Profile</a>
      			<a href="#">Help & Support</a>
      			<a href="Logout.php">Logout</a>
    	</div>
    	</li>
		</ul>

	</header>

	<div class = "info">
		<div class = "cred">

			<?php
			$select = "SELECT `username`, `fname`, `lname`
						FROM `credentials` WHERE `username` = '$_SESSION[visit_user]'";
			$res = $conn -> query($select);
			$uname = $fname = $lname = "";
			while($row = $res -> fetch_assoc()){
				$uname = $row["username"];
				$fname = $row["fname"];
				$lname = $row["lname"];
			}
			?>
			<div id = uname>Username: <?php echo $uname; ?></div>
			<div id = name><?php echo $fname." ".$lname; ?></div>
			<div class = "msgbox">
				<a href="Talk.php?user=<?php echo $_SESSION["visit_user"]; ?>" class = "msg">Message</a>
			</div>
			
		</div>
	</div>

</body>
</html>