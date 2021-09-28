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
?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Help & Support</title>
	<link rel="stylesheet" type="text/css" href="Help_and_SupportCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<link rel="stylesheet" type="text/css" href="SearchCSS.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="Help_and_SupportJS.js"></script>
	<script type="text/javascript" src="SearchJS.js"></script>
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
      			<a href="Profile.php">Profile</a>
      			<a href="Help_and_Support.php">Help & Support</a>
      			<a href="Logout.php">Logout</a>
    	</div>
    	</li>
		</ul>

	</header>

	<div id="sres">
		<?php
		$select = "SELECT `username`, `fname`, `lname`, `pic`
					FROM `credentials`
					WHERE `username` != '$_SESSION[usern]'
					ORDER BY `username` ASC";
		$res = $conn -> query($select);
		while($row = $res -> fetch_assoc()){
			?>
			<a href = "Reroute(Dashboard_to_VisitUser).php?user=<?php echo $row["username"]; ?>">
				<div class = "chaturc"><img src="<?php echo $row["pic"]; ?>" id="chatur" style="width:40px;height:40px"></div>
				<h5>
				<?php echo $row["fname"]." ".$row["lname"]; ?>
				</h5>
			</a>
			<?php
		}
		?>
	</div>

	<div id = "help">
		<div class="helpme" id="help1"><h4>How to Change Profile Picture?</h4></div>
		<div class="helpme" id="help2"><h4>How Can I Access the Edit Page?</h4></div>
		<div class="helpme" id="help3"><h4>How Can I Change My Name?</h4></div>
		<div class="helpme" id="help4"><h4>Is Account Deletion Available?</h4></div>
		<div class="helpme" id="help5"><h4>How To Order?</h4></div>
		<div class="helpme" id="help6"><h4>How to Talk with Others?</h4></div>
		<div class="helpme" id="help7"><h4>How to Cancel Pending Orders?</h4></div>
		<div class="helpme" id="help8"><h4>How to Change Password?</h4></div>
		<div class="helpme" id="help9"><h4>Who are The People Behind This Website?</h4></div>
	</div>

	<div id = "chatbox">
		<div id = "chat"></div>
	</div>

	<div id = "send">
		<form action = "">
			<input type = "text" name = "msg" placeholder = "Type your message here, the devs will respond shortly. Profanity is STRICTLY PROHIBITED!" id = "msg"/>
			<button type = "button" id = "sendm"><i class="fas fa-location-arrow"></i></button>
		</form>
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