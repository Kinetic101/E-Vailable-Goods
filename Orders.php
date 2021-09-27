<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
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

	$get_num = "SELECT DISTINCT(`id`) 
				FROM `orders` 
				WHERE `username` = '$_SESSION[usern]' AND `state` = 0
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

	<div id="orders">
		<?php
		$res_num = $conn -> query($get_num);
		while($row_num = $res_num -> fetch_assoc()){
			$select = "SELECT `productname`
						FROM `orders`
						WHERE `id` = '$row_num[id]'";
			$res = $conn -> query($select);
			$n = mysqli_fetch_array($conn -> query("SELECT COUNT(`productname`)
														FROM `orders`
														WHERE `id` = '$row_num[id]'"))[0];
			$i = 0;
			?>
			<a href="Reroute(Orders_to_OrderDetails).php?id=<?php echo $row_num["id"]; ?>">
				<?php echo "Order ID#".$row_num["id"]; ?>
				<br>
				<?php
				while($row = $res -> fetch_assoc()){
					echo $row["productname"];
					if($i < $n-1){
						echo ", ";
					}
					$i++;
				}
				?>
			</a>
			<br>
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