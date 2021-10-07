<!DOCTYPE html>
<?php
	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}
	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server,$usname,$pass,$dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn->connect_error);
	}
	$_SESSION["market"] = "";
	$_SESSION["visit_user"] = "";
?>

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="AboutCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<link rel="stylesheet" type="text/css" href="SearchCSS.css">
	<link rel="stylesheet" type="text/css" href="NavBarCSS.css">
	<script src="https://kit.fontawesome.com/f463b44b8d.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="SearchJS.js"></script>
	<script type="text/javascript" src="NavBarJS.js"></script>
	<title>About Us</title>
</head>
<body>

	<div id="wait">
		<div class="wait">
			<i class="fa fa-spinner fa-pulse"></i>
			<h5>Loading...</h5>
			<h5>Please Wait</h5>
		</div>
	</div>

	<header>
		<i class="fas fa-bars" id ="burg"></i>
			<div id="nav" ><nav>
			<ul class="links">
				<li><a href="Research.php">Buy</a></li>
				<li id="here"><a href="Talk.php">Talk</a></li>
				<li><a href="Edit.php">Edit</a></li>
				<li><a href="Suggest.php">Suggest</a></li>
				<li id="press"><a href="About.php" id="press">About</a></li>
				<li class="search-bar">
					<input type="text" placeholder="Search for others" class="inp">
					<i class="fas fa-search"></i>
					<div id="sres"></div>
				</li>
			</ul>
		</nav></div>
		<ul class="icons">
			<li><a href="Cart.php" title="Cart"><i class="fas fa-shopping-cart" id="cart"></i></a></li>
			<li><a href="Notifications.php" id="notifsss" title="Notifications"><i class="fas fa-bell" id="bell"></i></a></li>
			<li><a href="Orders.php" title="Orders"><i class="fas fa-receipt"></i></a></li>
		</ul>
		<a href = "Research.php" class = "evg">E-Vailable Goods</a>
		<ul>
		<li class = "dropdown">
			<div class="prof"><img src = "<?php echo $_SESSION["prof_pic"]?>" alt = "Avatar" class = "dp" id="disp">
			</div>
		<div class="dlinks" id="drop">
      			<a href="Profile.php">Profile</a>
      			<a href="Help_and_Support.php">Help & Support</a>
      			<a href="Logout.php">Logout</a>
    	</div>
    	</li>
		</ul>
	</header>
	
	<div class = "about">
		<h2 id = "us">About Us</h2>
	<p class = "us">
		Hello there!
		<br>
		We are students from the Philippine Science High School - Bicol Region Campus of Batch 2022 whose goal is to create and maintain a website that aims to
		lessen food waste as part of a research project. 
	</p>
	</div>
	<div class = "aboutp">
		<h2 id = "page">E-Vailable Goods</h2>
		<hr>
	<p class = "page">
		 is a platform that virtually connects markets, buyers, government agencies, and even those unfortunate enough to have food on their table so that they would not have to venture out of their respective homes given the Philippines' current state.
		<br><br>
		Thousands if not, millions of kilograms of food are thrown to waste because of oversupply. However, even though there is a presence of oversupply, many of our fellow Filipinos regularly sleep with little to no food in their stomachs. With this, we do not just want to lessen food wastes but, also give a light of hope to our fellow countrymen who unfortunately do not have the ability to put food on their tables.
		<br><br>
		All Rights Reserved 2021 - Cian Joseph Catimbang, John Eric Estrada, Julius Christian Namata PSHS-BRC Batch 2k22
	</p>
	</div>
		
</body>
</html>