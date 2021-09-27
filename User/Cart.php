<!DOCTYPE html>
<script type="text/javascript">
	var arr = {};
</script>
<?php
	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$_SESSION["market"] = "";
	$_SESSION["product"] = "";
	$_SESSION["visit_user"] = "";
	$_SESSION["buy_arr"] = array();
	$_SESSION["author"] = 0;

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

	$n = mysqli_fetch_array($conn -> query("SELECT COUNT(*) 
											FROM `cart` 
											WHERE `username` = '$_SESSION[usern]'"))[0];
	$select = "SELECT * 
				FROM `cart` 
				WHERE `username` = '$_SESSION[usern]'";

	
	$res = $conn -> query($select);
	$checkchange = 0;
	$checkzero = 0;
	while($row = $res -> fetch_assoc()){
		$check_orderq = "SELECT `quantity` 
							FROM `market` 
							WHERE `productname` = '$row[productname]' AND `market_name` = '$row[market]'";
		$temp = $conn -> query($check_orderq);
		$q = 0;
		while($row_q = $temp -> fetch_assoc()){
			$q = $row_q["quantity"];
		}

		if($q == 0){
			$delete = "DELETE FROM `cart` 
						WHERE `username` = '$_SESSION[usern]' AND `productname` = '$row[productname]' AND `market` = '$row[market]'";
			$conn -> query($delete);
			$checkzero++;
		}
		else if($row["order_quantity"] > $q){
			$update = "UPDATE `cart`
						SET `order_quantity` = '$q' 
						WHERE `username` = '$_SESSION[usern]' AND `productname` = '$row[productname]' AND `market` = '$row[market]'";
			$conn -> query($update);
			$checkchange++;
		}

		$check_orderp = "SELECT `price` 
							FROM `market` 
							WHERE `productname` = '$row[productname]' AND `market_name` = '$row[market]'";
		$temp = $conn -> query($check_orderp);
		$p = 0;
		while($row_p = $temp -> fetch_assoc()){
			$p = $row_p["price"];
		}
		$update = "UPDATE `cart`
					SET `price` = '$p'
					WHERE `username` = '$_SESSION[usern]' AND `productname` = '$row[productname]' AND `market` = '$row[market]'";
		$conn -> query($update);
	}
?>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="CartCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<title>Cart</title>

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
			<li><a href="Cart.php" title="Cart"><i class="fas fa-shopping-cart" id="press"></i></a></li>
			<li><a href="Notifications.php" id="notifsss" title="Notifications"><i class="fas fa-bell" id="bell"></i></a></li>
			<li><a href="Orders.php" title="Orders"><i class="fas fa-receipt"></i></a></li>
		</ul>
		<a href = "Research.php" class = "evg">E-Vailable Goods</a>
		<ul>
			<li class = "dropdown">
				<a href = "Profile.php" class="pic">
					<div class="prof"><img src = "<?php echo $_SESSION["prof_pic"]?>" alt = "Avatar" class = "dp"></div>
				</a>
				<div class="dlinks">
	      			<a href="Profile.php">Profile</a>
	      			<a href="Help_and_Support.php">Help & Support</a>
	      			<a href="Logout.php">Logout</a>
	    		</div>
	    	</li>
		</ul>
		
	</header>
	<div id = "items">
		<h1 class = "ioyc">ITEMS IN YOUR CART</h1>
		<hr>
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<?php
				$res = $conn -> query($select);
				$i = 0;
				$arr_max = array();
				while($row = $res -> fetch_assoc()){
					$idn = "id".strval($i);
					$uni = $idn."unit";
					$num = $idn."num";
					$pro = $idn."pro";
					$mar_roxas = $idn."mar_roxas";
					$pr = $idn."pr";
					$un = $idn."un";
					$temp = $row["productname"];
					?>
					<script type="text/javascript">
						arr["<?php echo $row["productname"];?>"] = <?php echo $row["order_quantity"];?>;
					</script>
					<?php
					$get_max = "SELECT `quantity` FROM `market` WHERE `productname` = '$row[productname]' AND `market_name` = '$row[market]'";
					$res_max = $conn -> query($get_max);
					$maxi = 0;
					while($row_max = $res_max -> fetch_assoc()){
						$maxi = $row_max["quantity"];
					}
					$arr_max[$i] = $maxi;
					?>
					<div class = "itemsa" id="<?php echo $idn."wow"; ?>">
						<label class = "checkbox">
							<div class = "eman">
								<label for = "<?php echo $idn; ?>"><?php echo $row["productname"]; ?></label>
							</div>
							<input type = "checkbox" id = "<?php echo $idn; ?>" name = "<?php echo $idn; ?>">
							<span class = "checkmark"></span>
						</label>
						<script type="text/javascript">
							var x = "#"+'<?php echo $idn; ?>';
							$(x).click(function(){
								if(document.getElementById('<?php echo $idn; ?>').checked){
									document.getElementById('<?php echo $idn."wow"; ?>').style.outline = "2px solid #4A7C59";
								}
								else{
									document.getElementById('<?php echo $idn."wow"; ?>').style.outline = "none";
								}
							})
						</script>
						<div class = "orderq">
							Quantity: 
							<p id = "<?php echo $uni?>">
								<?php echo $row["order_quantity"]; ?>
							</p>
							<?php echo " ".$row["unit"]." "; ?>
							<button id = minus type = button 
								onclick = "function dec(){
												if(arr['<?php echo $temp; ?>'] > 0){
													document.getElementById('<?php echo $num; ?>').value = 
														document.getElementById('<?php echo $uni; ?>').innerHTML = --arr['<?php echo $temp; ?>'];
												}
											}	
											dec();">-
							</button>
							<button id = plus type = button 
								onclick = "function inc(){
												if(arr['<?php echo $temp; ?>'] < '<?php echo  $arr_max[$i]; ?>'){
													document.getElementById('<?php echo $num; ?>').value = 
														document.getElementById('<?php echo $uni; ?>').innerHTML = ++arr['<?php echo $temp; ?>'];
												}
											}	
											inc();">+
							</button>
						</div>
						<input type = "hidden" id = "<?php echo $num; ?>" name = "<?php echo $num; ?>" value = <?php echo $row["order_quantity"]; ?>>
						<input type = "hidden" name = "<?php echo $pro; ?>" value = <?php echo $row["productname"]; ?>>
						<input type = "hidden" name = "<?php echo $mar_roxas; ?>" value = <?php echo $row["market"]; ?>>
						<input type = "hidden" name = "<?php echo $pr; ?>" value = <?php echo $row["price"]; ?>>
						<input type = "hidden" name = "<?php echo $un; ?>" value = <?php echo $row["unit"]; ?>>
						<div class = "priceid">Price: <?php echo $row["price"]; ?></div>
						<div class = "fmarket">From: <?php echo $row["market"]; ?></div>
					</div>
					<?php
					$i++;
				}
			?>

			<footer>
				<input type = "submit" value = "Remove" id = "remove" name = "remove">
				<input type = "submit" value = "Save" id = "save" name = "save">
				<input type = "submit" value = "Buy Now" id = "buynow" name = "buy">
			</footer>
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
<?php
	if($checkchange > 0){
		?>
		<script type = "text/javascript"> 
			swal({
					title: "Changes In Your Cart", 
					text: "Some products in your cart have quantities which are more than the maximum quantity available. We have already adjusted them for you!", 
					icon: "warning"
				});
		</script>
		<?php
	}
	if($checkzero > 0){
		?>
		<script type = "text/javascript"> 
			swal({
					title: "Out of Stock", 
					text: "Some products in your cart are out of stock. We have already removed them for you!", 
					icon: "warning"
				});
		</script>
		<?php
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		//If buy button is clicked.

		if(isset($_POST["buy"])){
			$cnt = 0;
			$error = False;
			$_SESSION["buy_arr"] = array();
			for($i = 0; $i < $n; $i++){
				$idn = "id".strval($i);
				$num = $idn."num";
				$pro = $idn."pro";
				$mar_roxas = $idn."mar_roxas";
				$pr = $idn."pr";
				$un = $idn."un";
				if(isset($_POST[$idn])){
					if($_POST[$num] == 0){
						$error = True;
						break;
					}
					$_SESSION["buy_arr"][$cnt++] = [$_POST[$num], $_POST[$pro], $_POST[$mar_roxas], $_POST[$pr], $_POST[$un]];
				}
			}
			if($cnt > 0 && !$error){
				for($i = 0; $i < $n; $i++){
					$idn = "id".strval($i);
					$num = $idn."num";
					$pro = $idn."pro";
					$mar_roxas = $idn."mar_roxas";
					$pr = $idn."pr";
					$un = $idn."un";
					$update = "UPDATE `cart` 
								SET `order_quantity` = '$_POST[$num]'
								WHERE `productname` = '$_POST[$pro]' AND `username` = '$_SESSION[usern]' AND `market` = '$_POST[$mar_roxas]'";

				}
				?>
				<script type = "text/javascript"> 
					swal({
						title: "Redirecting", 
						text: "You will now be redirected to the confirmation page", 
						icon: "warning"
					})
					.then(function(){
						location.href = 'Confirm_Buy.php';
					});
				</script>
				<?php
			}
			else{
				$_SESSION["buy_arr"] = array();
				?>
				<script type = "text/javascript"> 
					swal({
						title: "Invalid", 
						text: "You have not selected at least one product", 
						icon: "error"
					})
					.then(function(){
						location.href = 'Confirm_Buy.php';
					});
				</script>
				<?php
			}
		}

		//If remove button is clicked.

		else if(isset($_POST["remove"])){
			for($i = 0; $i < $n; $i++){
				$idn = "id".strval($i);
				$num = $idn."num";
				$pro = $idn."pro";
				$mar_roxas = $idn."mar_roxas";
				if(isset($_POST[$idn])){
					$delete = "DELETE FROM `cart`
								WHERE `productname` = '$_POST[$pro]' AND `username` = '$_SESSION[usern]' AND `market` = '$_POST[$mar_roxas]'";
					$conn -> query($delete);
				}
			}
			?>
			<script type = text/javascript> 
				swal({
						title: "Products Removed", 
						text: "All of the selected products have been removed from your cart", 
						icon: "success"
					})
					.then(function(){
						location.href = 'Cart.php';
					});
			</script>
			<?php
		}

		//If save button is clicked.

		else if(isset($_POST["save"])){
			for($i = 0; $i < $n; $i++){
				$idn = "id".strval($i);
				$num = $idn."num";
				$pro = $idn."pro";
				$mar_roxas = $idn."mar_roxas";
				$update = "";
				if($_POST[$num] > 0){
					$update = "UPDATE `cart` 
								SET `order_quantity` = '$_POST[$num]'
								WHERE `productname` = '$_POST[$pro]' AND `username` = '$_SESSION[usern]' AND `market` = '$_POST[$mar_roxas]'";
				}
				else{
					$update = "DELETE FROM `cart`
								WHERE `productname` = '$_POST[$pro]' AND `username` = '$_SESSION[usern]' AND `market` = '$_POST[$mar_roxas]'";
				}
				$conn -> query($update);
			}
			?>
			<script type = text/javascript> 
				swal({
						title: "Products Saved", 
						text: "All selected products have been successfully changed", 
						icon: "success"
					})
					.then(function(){
						location.href = 'Cart.php';
					});
			</script>
			<?php
		}
	}
?>