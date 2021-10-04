<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}
	if(isset($_GET["market"])){
		$_SESSION["market"] = $_GET["market"];
	}
	if($_SESSION["market"] == ""){
		header("Location: Research.php");
	}

	$_SESSION["visit_user"] = "";


	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

	$select = "SELECT * 
				FROM `market` 
				WHERE `market_name` = '$_SESSION[market]'";
	$n = mysqli_fetch_array($conn -> query("
										SELECT COUNT(*) 
										FROM `market` 
										WHERE `market_name` = '$_SESSION[market]'"))[0];
	$arr = array();

	$res = $conn -> query($select);
	while($row = $res -> fetch_assoc()){
		$arr[$row["productname"]] = 0;
	}
?>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="MarketCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<link rel="stylesheet" type="text/css" href="SearchCSS.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="SearchJS.js"></script>
	<script type="text/javascript" src="MarketJS.js"></script>
	<title><?php echo $_SESSION["market"]?></title>

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
      			<a href="Profile.php">Profile</a>
      			<a href="Help_and_Support.php">Help & Support</a>
      			<a href="Logout.php">Logout</a>
    	</div>
    	</li>
		</ul>

	</header>
	<div class = "buyp">
	<h1 id = "buy">Buy</h1>
	<hr id = "fr">
	</div>
	<div class = "product_table">
		<div class = "pname">
			<h3>Product Name</h3>
			<hr id="fhr">
			<?php
				$res = $conn -> query($select);
				while($row = $res->fetch_assoc()) {
					?>
					<div class = "filler"><?php echo $row["productname"]; ?></div>
					<hr>
					<?php
				}
			?>
		</div>

		<div class = "quantity">
			<h3>Quantity</h3>
			<hr id="fhr">
			<?php
				$res = $conn -> query($select);
				while($row = $res->fetch_assoc()) {
					?>
					<div class = "filler"><?php echo $row["quantity"]; ?></div>
					<hr>
					<?php
				}
			?>
		</div>

		<div class = "unit">
			<h3>Unit</h3>
			<hr id="fhr">
			<?php
				$res = $conn -> query($select);
				while($row = $res->fetch_assoc()) {
					?>
					<div class = "filler"><?php echo $row["unit"]; ?></div>
					<hr>
					<?php
				}
			?>
		</div>

		<div class = "price">
			<h3>Price</h3>
			<hr id="fhr">
			<?php
				$res = $conn -> query($select);
				while($row = $res->fetch_assoc()) {
					?>
					<div class = "filler">Php <?php echo $row["price"]; ?></div>
					<hr>
					<?php
				}
			?>
		</div>
		<div class = "buy">
			<h3>Add to Cart</h3>
			<hr id="fhr">
			<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<?php
					$i  = 0;
					$res = $conn -> query($select);
					while($row = $res -> fetch_assoc()) {
						array_push($arr, $row["productname"]);
						if($row["quantity"] == 0){
						?>
							<div class = "filler">Out of Stock</div>
							<hr>
						<?php
						}
						else{
							$idname = "num".strval($i);
							$temp_var = $row["productname"];
							?>
							<div class = filler>
								<input id = "<?php echo $idname; ?>" type = "number" name = "<?php echo $row["productname"]; ?>" 
									value = "<?php echo $arr[$temp_var]; ?>" min = 0 max = "<?php echo $row["quantity"]; ?>" />
								<button id = "minus" type = "button" onclick = "dec('<?php echo $idname; ?>');" >-</button>
								<button id = "plus" type = "button" onclick = "inc('<?php echo $idname; ?>');">+</button>
								<script type="text/javascript">
									function check_vals(){
										if(document.getElementById('<?php echo $idname; ?>').value > 0){
											document.getElementById('<?php echo $idname; ?>').style.cssText = 'box-shadow: 0 0 0 4px #4A7C59;';
										}
										else{
											document.getElementById('<?php echo $idname; ?>').style.cssText = 'box-shadow: none;';
										}
									}
									setInterval(check_vals, 10);
								</script>
							</div>
							<hr>
							<?php
						}
						$i++;
					}
				?>
				<input type = "submit" value = "Add to Cart" class = "addtocart">
			</form>
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
<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$res = $conn -> query($select);
		$i = $cnt = 0;

		while($row = $res -> fetch_assoc()){
			if($row["quantity"] == 0){
				continue;
			}
			if($_POST[$row["productname"]] > 0){
				$cnt++;
				$temp_var = $_POST[$row["productname"]] ;
				$check = "SELECT COUNT(*) 
							FROM `cart`
							WHERE `market` = '$_SESSION[market]' AND `username` = '$_SESSION[usern]' AND `productname` = '$row[productname]'";

				if(mysqli_fetch_array($conn -> query($check))[0] == 0){
					$insert = "INSERT INTO `cart` (`username`, `productname`, `order_quantity`, `unit`, `price`, `market`)
								VALUES ('$_SESSION[usern]', '$row[productname]', '$temp_var', '$row[unit]', '$row[price]', '$_SESSION[market]')";
					$conn -> query($insert);
				}
				else{
					$new_order_q = 0;
					$temp_q = "SELECT `order_quantity` 
								FROM `cart` 
								WHERE `market` = '$_SESSION[market]' AND `username` = '$_SESSION[usern]' AND `productname` = '$row[productname]'";
					$res2 = $conn -> query($temp_q);
					while($row2 = $res2 -> fetch_assoc()){
						$new_order_q = $row2["order_quantity"];
					}
					$new_order_q += $temp_var;
					$update = "UPDATE `cart` 
								SET `order_quantity` = '$new_order_q' 
								WHERE `market` = '$_SESSION[market]' AND `username` = '$_SESSION[usern]' AND `productname` = '$row[productname]'";
					$conn -> query($update);
				}
			}
			$i++;
		}

		if($cnt > 0){
			?>
			<script type = "text/javascript">
				swal({
						title: "Added to Cart", 
						text: "All selected products have been added to cart", 
						icon: "success"
					})
					.then(function(){
						location.href = 'Market.php';
					});
			</script>
			<?php
		}
		else{
			?>
			<script type = "text/javascript">
				swal({
						title: "Invalid", 
						text: "You have not selected at least one product", 
						icon: "error"
					})
					.then(function(){
						location.href = 'Market.php';
					});
			</script>
			<?php
		}
	}
?>