<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}
	if(isset($_GET["id"])){
		$_SESSION["order_id"] = $_GET["id"];
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
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/f463b44b8d.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel = "stylesheet" href = "OrderDetailsCSS.css"> 
	<link rel="stylesheet" type="text/css" href="NavBarCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="NavBarJS.js"></script>
	<title>Order Details - ID#<?php echo $_SESSION["order_id"]?></title>
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
	                <li class="nav-item active">
	                    <a class="nav-link" href="Orders.php"><i class="fas fa-clipboard-list"></i>Orders</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Messages.php"><i class="fas fa-inbox"></i>Messages</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Edit.php"><i class="fas fa-edit"></i>Edit</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Logout.php"><i class="fas fa-sign-out-alt"></i>Log Out</a>
	                </li>
	            </ul>
	        </div>
	    </nav>
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
	
</body>
</html>