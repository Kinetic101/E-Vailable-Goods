<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}
	if($_SESSION["order_id"] == ""){
		header("Orders.php");
	}

	$_SESSION["market"] = "";
	$_SESSION["visit_user"] = "";
	$_SESSION["author"] = 0;

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

	$select = "SELECT *
				FROM `orders`
				WHERE `id` = '$_SESSION[order_id]'";
	$res = $conn -> query($select);
	$tot = 0;
?>
<html>
<head>
	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel = "stylesheet" href = "OrderDetailsCSS.css"> 
	<link rel="stylesheet" type="text/css" href="OnlineCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<title>E-Vailable Goods</title>
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

	<div id="ongoing">
		<!--Button here (Ongoing Orders) -->
	</div>

	<div id="finished">
		<!--Button here (Finished Orders) -->
	</div>

	<div id="back">
		<a href="Orders.php"><i class="fas fa-arrow-left"></i></a>
	</div>

	<div id="details">
		<h2>Order ID#<?php echo $_SESSION["order_id"]; ?></h2>
		<div class = "items">
			<div class = "title">
				<h4 id = "eman">Product</h4>
				<h4 id = "quan">Quantity</h4>
				<h4 id = "price">Price</h4>
				<h4 id = "tprice">Total Price</h4>
			</div>
		<?php				
			while($row = $res -> fetch_assoc()) {
			?>
			<div class = "uni">
				<div class = "eman"> <?php echo $row["productname"]; ?></div>
				<div class = "unit">x</div>
				<div class = "quan"> <?php echo $row["order_quantity"]." ".$row["unit"]; ?></div>
				<div class = "unit">x</div>
				<div class = "price">Php <?php echo $row["price_as_of_order"]; ?></div>
				<div class = "unit">=</div>
				<div class = "tprice">Php <?php echo $row["price_as_of_order"]*$row["order_quantity"]; ?></div>
			</div>
			<span id = "market">From Market: <?php echo $row["market"]; ?></span>
			<br>
			<br>
			<?php
			$tot += $row["price_as_of_order"]*$row["order_quantity"];
			}
		?>
			<div class = "tamount">
				<span id = "tamount">Total Amount:</span> 
				<span id = "tantamount">Php <?php echo $tot; ?></span>
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