<?php
	//Connect to SQL database
	session_start();

	if($_SESSION["admin"] == ""){
		header("Location: Login.php");
	}

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname_user = "user";
	$dbname_admin = "admin";
	$conn_user = new mysqli($server, $usname, $pass, $dbname_user);
	$conn_admin = new mysqli($server, $usname, $pass, $dbname_admin);
	if($conn_user -> connect_error){
		die("Connection Failed: ".$conn_user -> connect_error);
	}
	if($conn_admin -> connect_error){
		die("Connection Failed: ".$conn_admin -> connect_error);
	}

	$_SESSION["user"] = "";
	$_SESSION["market"] = "";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel = "stylesheet" href = "EditCSS.css"> 
	<link rel="stylesheet" type="text/css" href="NavBarCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="NavBarJS.js"></script>
	<title>Admin - Edit</title>
</head>
<body>

	<header>
		<nav class="navbar navbar-expand-custom navbar-mainbg">
	        <a class="navbar-brand navbar-logo" href="#">E-Vailable Goods - Administration Website</a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	        <i class="fas fa-bars text-white"></i>
	        </button>
	        <div class="collapse navbar-collapse" id="navbarSupportedContent">
	            <ul class="navbar-nav ml-auto">
	                <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
	                <li class="nav-item">
	                    <a class="nav-link" href="Dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Users.php"><i class="far fa-address-book"></i>Users</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Notifications.php"><i class="fas fa-bell"></i>Notifications</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Orders.php"><i class="fas fa-clipboard-list"></i>Orders</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Messages.php"><i class="fas fa-inbox"></i>Messages</a>
	                </li>
	                <li class="nav-item active">
	                    <a class="nav-link" href="Edit.php"><i class="fas fa-edit"></i>Edit</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Logout.php"><i class="fas fa-sign-out-alt"></i>Log Out</a>
	                </li>
	            </ul>
	        </div>
	    </nav>
	</header>

	<div class = "market">
		<h1 id = "mhead">EDIT MARKETS</h1>
		<hr>

		<a href="MarketEdit.php?market=market1">
		<div class = "marketsa">
			<h2 class = "md">Market 1</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="MarketEdit.php?market=market2">
		<div class = "marketsa">
			<h2 class = "md">Market 2</h2>
			<img src="pal.png">
		</div>
		</a>

		<a href="MarketEdit.php?market=market3">
		<div class = "marketsa">
			<h2 class = "md">Market 3</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="MarketEdit.php?market=market4">
		<div class = "marketsa">
			<h2 class = "md">Market 4</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="MarketEdit.php?market=market5">
		<div class = "marketsa">
			<h2 class = "md">Market 5</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="MarketEdit.php?market=market6">
		<div class = "marketsa">
			<h2 class = "md">Market 6</h2>
			<img src="default.jpg">
		</div>
		</a>

	</div>

	<div id="loading">
		<div class="content">
			<div class="load-wrapp">
				<div class="load">
					<p>Loading</p>
					<div class="line"></div>
					<div class="line"></div>
					<div class="line"></div>
				</div>
			</div>
		</div>
		<!--Credits to @Manoz from CodePen for the loading screen-->
	</div>

</body>
</html>