<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$_SESSION["market"] = "";
	$_SESSION["visit_user"] = "";

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

	$on = mysqli_fetch_array($conn -> query("SELECT COUNT(*)
												FROM `credentials`
												WHERE `username` = '$_SESSION[usern]' AND `user_type` = 1"))[0];
	if($on == 0){
		?>
		<script type = text/javascript>
			alert('You do not have market admin priviliges.');
			location.href = 'Research.php';
		</script>
		<?php
	}

?>
<html>
<head>

	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel = "stylesheet" href = "EditCSS.css"> 
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="GetOnlineJS.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<title>E-Vailable Goods</title>

</head>
<body>

	<header>
		<nav>
			<ul class="links">
				<li><a href="Research.php">Buy</a></li>
				<li><a href="Talk.php">Talk</a></li>
				<li><a href="Edit.php" id = "press">Edit</a></li>
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
			<div class="prof"><img src = "<?php echo $_SESSION["prof_pic"]?>" alt = "Avatar" class = "dp">
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

	<div class = "market">
		<h1 id = "mhead">EDIT MARKETS YOU ARE ELIGIBLE TO EDIT</h1>
		<hr>

		<a href="Reroute(Edit_to_MarketEdit).php?market=market1">
		<div class = "marketsa">
			<h2 class = "md">Market 1</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="Reroute(Edit_to_MarketEdit).php?market=market2">
		<div class = "marketsa">
			<h2 class = "md">Market 2</h2>
			<img src="pal.png">
		</div>
		</a>

		<a href="Reroute(Edit_to_MarketEdit).php?market=market3">
		<div class = "marketsa">
			<h2 class = "md">Market 3</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="Reroute(Edit_to_MarketEdit).php?market=market4">
		<div class = "marketsa">
			<h2 class = "md">Market 4</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="Reroute(Edit_to_MarketEdit).php?market=market5">
		<div class = "marketsa">
			<h2 class = "md">Market 5</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="Reroute(Edit_to_MarketEdit).php?market=market6">
		<div class = "marketsa">
			<h2 class = "md">Market 6</h2>
			<img src="default.jpg">
		</div>
		</a>

	</div>

	<div id = "active"></div>

</body>
</html>