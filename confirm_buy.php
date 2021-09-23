<!DOCTYPE html>
<?php
	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$_SESSION["market"] = "";
	$_SESSION["product"] = "";
	$_SESSION["visit_user"] = "";

	if(empty($_SESSION["buy_arr"])){
		header("Location: Cart.php");
	}

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$contact = $add = "";
	$contactErr = $addErr = "";
	$error = $input = False;
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$input = True;
		if(isset($_POST["cancel"])){
			unset($_SESSION["buy_arr"]);
			header("Location: Cart.php");
		}
		else{
			if(empty($_POST["contact"])){
				$error = True;
				$contactErr = "Contact number cannot be empty!";
			}
			else{
				$contact = test_input($_POST["contact"]);
			}
			if(empty($_POST["add"])){
				$error = True;
				$addErr = "Address cannot be empty!";
			}
			else{
				$add = test_input($_POST["add"]);
			}
			if($input){
				if(!$error){
					foreach($_SESSION["buy_arr"] as $key => $value) {
						$prod = $value[1];
						$mark = $value[2];
						$ordr = $value[0];
						$unit = $value[4];
						$pric = $value[3];
						$order_q = 0;

						//Update Cart Table

						$delete = "DELETE FROM `cart`
										WHERE `username` = '$_SESSION[usern]' AND `market` = '$mark' AND `productname` = '$prod'";
						$conn -> query($delete);

						//Update Market Table

						$know_pro_q = "SELECT `quantity` 
										FROM `market` 
										WHERE `market_name` = '$mark' AND `productname` = '$prod'";
						$res_q = 0;
						$temp = $conn -> query($know_pro_q);
						while($row = $temp -> fetch_assoc()){
							$res_q = $row["quantity"];
						}
						$res_q -= $ordr;						
						$update = "UPDATE `market`
									SET `quantity` = '$res_q'
									WHERE `market_name` = '$mark' AND `productname` = '$prod'";
						$conn -> query($update);

						//Update Orders Table

						$n = mysqli_fetch_array($conn -> query("SELECT COUNT(*) 
																FROM `orders`"))[0];

						$insert = "INSERT INTO `orders`
									(`id`, `username`, `productname`, `order_quantity`, `unit`, `price_as_of_order`, `market`, `address`, `contact`, `state`)
									VALUES ('$n', '$_SESSION[usern]', '$prod', '$ordr', '$unit', '$pric', '$mark', '$add', '$contact', 0)";
						$n++; 
						$conn ->query($insert);

					}
					unset($_SESSION["buy_arr"]);
					?>
					<script type = "text/javascript"> 
						alert('Thank you for using our service!');
						location.href  = 'Cart.php';
					</script>
					<?php
				}
			}
		}
	}

?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="Confirm_BuyCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<title>Transaction Confirmation</title>
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
			<li><a href="Notifications.php" id="notifsss" title="Notifications"><i class="fas fa-bell-slash" id="bell"></i></a></li>
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
      		<a href="#">Help & Support</a>
      		<a href="Logout.php">Logout</a>
    	</div>
    	</li>
		</ul>
		
	</header>
		<div id = "prod">
		<h3 class = "disc">
			You are about to make a legitimate transaction. An order will be made once you click the order button. 
			All orders that have been already confirmed <span style = "color:#BF2722; font-weight:1000">CANNOT</span> be cancelled anymore. <br> 
			For problems that may arise with regards to your order, the admins of this website are not liable for it, 
			except in cases due to problems caused by our servers. 
			<br>
			<br> 
			Below are the products that you are about to order:
		</h3>
			<hr>
		<div class = "items">
			<div class = "title">
			<h4 id = "eman">Product</h4>
			<h4 id = "quan">Quantity</h4>
			<h4 id = "price">Price</h4>
			<h4 id = "tprice">Total Price</h4>
		</div>
		<?php			
			$tot = 0;		
			foreach ($_SESSION["buy_arr"] as $key => $value) {
				?>
				<div class = "uni">
					<div class = "eman"> <?php echo $value[1]; ?></div>
					<div class = "unit">x</div>
					<div class = "quan"> <?php echo $value[0]." ".$value[4]; ?></div>
					<div class = "unit">x</div>
					<div class = "price">Php <?php echo $value[3]; ?></div>
					<div class = "unit">=</div>
					<div class = "tprice">Php <?php echo $value[3]*$value[0]; ?></div>
				</div>
				<span id = "market">From Market: <?php echo $value[2]; ?></span>
				<br>
				<br>
				<?php
				$tot += $value[3]*$value[0];
			}
			?>
				<div class = "tamount">
					<span id = "tamount">Total Amount to Pay:</span> 
					<span id = "tantamount">Php <?php echo $tot; ?></span>
				</div>
			<?php
		?>
		</div>
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class = "cins">
				<label id = "contact">Contact Number: </label>
				<input type = "text" name = "contact" class = "field" id = "cn" value = "<?php echo $contact;?>"> <span class = "error">* <?php echo $contactErr;?></span>

				<!--Palitan natin to, instead na address/location lang iseparate natin into Town (towns sa Partido) tas respective brgys. ng kada town gawin mo lang yung dropdown inputs tas ako na dun sa nagapalit palit, yung pareho sa lazada/shopee so bale:

				Municipality (drodown)
				Brgy (dropdow)
				Street Address (simple text box)-->

				<label id = "add">Address/Location: </label>
				<input type = "text" name = "add" class = "field" id = "al" value = "<?php echo $add;?>"> <span class = "error">* <?php echo $addErr;?></span><br> 
			</div>

			
			<input type = "submit" value = "Cancel" id = "cancel" name = "cancel">
			<input type = "submit" value = "Order" id = "order" name = "order">
			<div class = "butts"></div>
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