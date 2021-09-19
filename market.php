<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
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
			echo "<script type = text/javascript>
					alert('All selected products have been added to cart.'); 
					location.href = 'Market.php';
				</script>";
		}
		else{
			echo "<script type = text/javascript>
					alert('No products have been selected!'); 
					location.href = 'Market.php';
				</script>";
		}
	}
?>

<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="MarketCSS.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<title><?php echo $_SESSION["market"]?></title>

</head>	
<body>
	
	<header>
		<nav>
			<ul class="links">
				<li><a href="Research.php">Buy</a></li>
				<li><a href="Talk.php">Talk</a></li>
				<li><a href="Edit.php">Edit</a></li>
				<li><a href="Suggest.php">Suggest</a></li>
				<li><a href="About.php">About</a></li>
			</ul>
		</nav>
		<ul class="icons">
			<li><a href="Cart.php"><i class="fas fa-shopping-cart" id="cart"></i></a></li>
			<li><a href="#"><i class="fas fa-bell"></i></a></li>
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
					echo "<div class = filler>".$row["productname"]."</div>\n\t\t\t"."<hr>\n\t\t\t";
				}
				echo"\n";
			?>
		</div>

		<div class = "quantity">
			<h3>Quantity</h3>
			<hr id="fhr">
			<?php
				$res = $conn -> query($select);
				while($row = $res->fetch_assoc()) {
					echo "<div class = filler>".$row["quantity"]."</div>\n\t\t\t"."<hr>\n\t\t\t";
				}
				echo"\n";
			?>
		</div>

		<div class = "unit">
			<h3>Unit</h3>
			<hr id="fhr">
			<?php
				$res = $conn -> query($select);
				while($row = $res->fetch_assoc()) {
					echo "<div class = filler>".$row["unit"]."</div>\n\t\t\t"."<hr>\n\t\t\t";
				}
				echo"\n";
			?>
		</div>

		<div class = "price">
			<h3>Price</h3>
			<hr id="fhr">
			<?php
				$res = $conn -> query($select);
				while($row = $res->fetch_assoc()) {
					echo "<div class = filler>".$row["price"]."</div>\n\t\t\t"."<hr>\n\t\t\t";
				}
				echo"\n";
			?>
		</div>
		<div class = "buy">
			<h3>Add to Cart</h3>
			<hr id="fhr">
			<form method = post action = <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
				<?php
					$i  = 0;
					$res = $conn -> query($select);
					while($row = $res -> fetch_assoc()) {
						array_push($arr, $row["productname"]);
						if($row["quantity"] == 0){
							echo "<div class = filler>\n\t\t\t\t\t"
							."Out of Stock\n\t\t\t\t"."</div>\n\t\t\t\t"."<hr>\n\t\t\t\t";
						}
						else{
							$idname = "num".strval($i);
							$temp_var = $row["productname"];
							echo "<div class = filler>\n\t\t\t\t\t"."<input id = $idname type = number name = $row[productname] value = $arr[$temp_var] min = 0 max = $row[quantity]>
							<button id = minus type = button onclick = \"
								function dec(){
									document.getElementById('$idname').stepDown();
								} 
								dec();\" >-</button>
							<button id = plus type = button onclick = \"
								function inc(){
									document.getElementById('$idname').stepUp();
								} 
								inc();\">+</button>\n\t\t\t\t"
							."</div>\n\t\t\t\t"
							."<hr>\n\t\t\t\t";
						}
						$i++;
					}
					echo "\n";
				?>
				<!--
					Kailangang nakafix position netong Add to Cart sa lower right ng page 
				-->
				<input type = "submit" value = "Add to Cart" class = "addtocart">
			</form>
		</div>
	</div>

</body>
</html>