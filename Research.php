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
?>

<!--
	kailangan natin ng dropdown para dun sa (id = "dp")
	dropdown items:
		*Profile
		*Help & Support
		*Settings
		*Log Out
	Lagay na lang ng dummy links tas ako na bahala sa backend 
-->

<html>
<head>

	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel = "stylesheet" href = "ResearchCSS.css"> 
	<title>E-Vailable Goods</title>

</head>
<body>

	<header>
		<nav>
			<ul class="links">
				<li><a href="Research.php" id = "press">Buy</a></li>
				<li><a href="Talk.php">Talk</a></li>
				<li><a href="Edit.php">Edit</a></li>
				<li><a href="Suggest.php">Suggest</a></li>
				<li><a href="About.php">About</a></li>
			</ul>
		</nav>
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
		<h1 id = "mhead">LOCAL MARKETS NEAR YOU</h1>
		<hr> 

		<a href="Reroute(Dashboard_to_Market).php?market=market1">
		<div class = "marketsa">
			<h2 class = "md">Market 1</h2>
			<img src="pal.png">
		</div>
		</a>

		<a href="Reroute(Dashboard_to_Market).php?market=market2">
		<div class = "marketsa">
			<h2 class = "md">Market 2</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="Reroute(Dashboard_to_Market).php?market=market3">
		<div class = "marketsa">
			<h2 class = "md">Market 3</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="Reroute(Dashboard_to_Market).php?market=market4">
		<div class = "marketsa">
			<h2 class = "md">Market 4</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="Reroute(Dashboard_to_Market).php?market=market5">
		<div class = "marketsa">
			<h2 class = "md">Market 5</h2>
			<img src="default.jpg">
		</div>
		</a>

		<a href="Reroute(Dashboard_to_Market).php?market=market6">
		<div class = "marketsa">
			<h2 class = "md">Market 6</h2>
			<img src="default.jpg">
		</div>
		</a>

	</div>
	
	<div class = "active">
		<h1 class = "now">Active Now</h1>
		<?php
			$select = "SELECT `username`, `fname`, `lname` FROM `credentials` WHERE `online` = 1 AND `username` != '$_SESSION[usern]'";
			$res = $conn -> query($select);
			while($row = $res -> fetch_assoc()) {
				echo "<a href = Reroute(Dashboard_to_VisitUser).php?user=$row[username]>"."<h5>".$row["fname"]." ".$row["lname"]."</h5>"."</a>";
			}
		?>
	</div>
</body>
</html>