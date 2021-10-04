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

	$get_num = "SELECT DISTINCT(`id`) 
				FROM `orders` 
				WHERE `username` = '$_SESSION[usern]' AND `state` = 1
				ORDER BY `date_time` DESC";
?>
<html>
<head>
	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel = "stylesheet" href = "OrdersCSS.css"> 
	<link rel="stylesheet" type="text/css" href="OnlineCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<link rel="stylesheet" type="text/css" href="SearchCSS.css">
	<script src="https://kit.fontawesome.com/f463b44b8d.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="SearchJS.js"></script>
	<title>Orders</title>
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
			<li><a href="Orders.php" title="Orders"><i class="fas fa-receipt" id="press"></i></a></li>
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

	<div class = "button">
	<a href="Orders.php"><div id="ongoing">
		<button type="button" id="nclickedd" class="og_orders">Ongoing</button>
	</div></a>

	<div id="finished">
		<button type="button" id="clickedd" class="fs_orders">Finished</button>
	</div>
	</div>

	<div id="orders">
		<?php
		$res_num = $conn -> query($get_num);
		$k = 0;
		while($row_num = $res_num -> fetch_assoc()){
			$k++;
			$select = "SELECT `productname`
						FROM `orders`
						WHERE `id` = '$row_num[id]'";
			$res = $conn -> query($select);
			$n = mysqli_fetch_array($conn -> query("SELECT COUNT(`productname`)
														FROM `orders`
														WHERE `id` = '$row_num[id]'"))[0];
			$i = 0;
			?>
			<a href="OrderDetails.php?id=<?php echo $row_num["id"]; ?>" class="orderlink">
				<span class = "oid"><?php echo "Order ID#".$row_num["id"]; ?></span><br><div class = "br"></div>
				<span class = "olist">
				<?php
				while($row = $res -> fetch_assoc()){
					echo $row["productname"];
					if($i < $n-1){
						echo ", ";
					}
					$i++;
				}
				?>
			</span></a>
			<hr>
			<?php
		}
		if($k == 0){
			?>
			<span class = "oid">You currently do not have finished orders.</span>
			<?php
		}
		?>
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