<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ""){
		header("Location: SignUp.php");
	}
	if(isset($_GET["user"])){
		$_SESSION["visit_user"] = $_GET["user"];
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
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<link rel="stylesheet" type="text/css" href="SearchCSS.css">
	<script src="https://kit.fontawesome.com/f463b44b8d.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="SearchJS.js"></script>
	<title><?php echo $_SESSION["visit_user"];?></title>
</head>
<body>
	<header>
		<nav>
			<ul class="links">
				<li><a href="Research.php">Buy</a></li>
				<li id="here"><a href="Talk.php">Talk</a></li>
				<li><a href="Edit.php">Edit</a></li>
				<li><a href="Suggest.php">Suggest</a></li>
				<li><a href="About.php">About</a></li>
				<li class="search-bar">
					<input type="text" placeholder="Search for others" class="inp">
					<i class="fas fa-search"></i>
					<div id="sres"></div>
				</li>
			</ul>
		</nav>
		<ul class="icons">
			<li><a href="Cart.php" title="Cart"><i class="fas fa-shopping-cart" id="cart"></i></a></li>
			<li><a href="Notifications.php" id="notifsss" title="Notifications"><i class="fas fa-bell" id="bell"></i></a></li>
			<li><a href="Orders.php" title="Orders"><i class="fas fa-receipt"></i></a></li>
		</ul>
		<a href = "Research.php" class = "evg">E-Vailable Goods</a>
		<ul>
		<li class = "dropdown"><a href = "Profile.php" class="pic">
			<div class="prof"><img src = "<?php echo $_SESSION["prof_pic"]?>" alt = "Avatar" class = "dp">
			</div>
		</a>
		<div class="dlinks">
      			<a href="Profile.php" id = "press">Profile</a>
      			<a href="Help_and_Support.php">Help & Support</a>
      			<a href="Logout.php">Logout</a>
    	</div>
    	</li>
		</ul>

	</header>

	<div class = "info">
		<?php
			$select = "SELECT `pic`, `username`, `fname`, `lname`, `user_type`
						FROM `credentials` WHERE `username` = '$_SESSION[visit_user]'";
			$res = $conn -> query($select);
			$uname = $fname = $lname = $utype = $pic = "";
			while($row = $res -> fetch_assoc()){
				$uname = $row["username"];
				$fname = $row["fname"];
				$lname = $row["lname"];
				$utype = $row["user_type"];
				$pic = $row["pic"];
			}
		?>
		<div class="mprof">
			<img src="<?php echo $pic; ?>" alt="Avatar" class="mdp">
		</div>
		<div class = "cred">

			
			<div id = "uname">Username: <?php echo $uname; ?></div>
			<div id = "name"><?php 
					echo $fname." ".$lname."<br>"; 
					if($utype == 0){
						echo "Customer";
					}
					else{
						echo "Market Administrator";
					}
				?>
			</div>
			<div class = "msgbox">
				<a href="Talk.php?user=<?php echo $_SESSION["visit_user"]; ?>" class = "msg">Message</a>
			</div>
			
		</div>
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