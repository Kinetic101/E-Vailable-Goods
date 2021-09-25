<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	else if($_SESSION["market"] == ""){
		header("Location: Research.php");
	}

	else if($_SESSION["author"] == 0){
		header("Location: Edit.php");
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

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$select = "SELECT * 
				FROM `market` 
				WHERE `market_name` = '$_SESSION[market]'";

	$prodname = $quan = $price = $unit = "";
	$err = "";
	$cnt = 0;
?>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="MarketEditCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="MarketEditJS.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<title><?php echo $_SESSION["market"]?> Edit</title>

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
	<div class = "buyp">
	<h1 id = "buy">Edit <?php echo $_SESSION["market"]?></h1>
	<hr id = "fr">
	</div>
	<div class = "product_table">
		<div class = "pname">
			<h3>Product Name</h3>
			<hr id ="fhr">
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
			<hr id ="fhr">
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
			<hr id ="fhr">
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
			<hr id ="fhr">
			<?php
				$res = $conn -> query($select);
				while($row = $res->fetch_assoc()) {
					?>
					<div class = "filler"><?php echo $row["price"]; ?></div>
					<hr>
					<?php
				}
			?>
		</div>
		<div class = "editp">
			<h3>Edit Quantity</h3>
			<hr id ="fhr">
			<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<?php
					$i  = 0;
					$arr = [];
					$res = $conn -> query($select);
					while($row = $res -> fetch_assoc()){
						$idname1 = "num1".strval($i);
						$temp_var1 = "a".$row["productname"];
						$arr[$row["productname"]] = $row["quantity"];
						?>
						<div class = "filler">
							<input id = "<?php echo $idname1; ?>" type = "number"  name = "<?php echo $temp_var1; ?>" value = "<?php echo $row["quantity"]; ?>" min = 0>
							<button class = "minus" id = "minus1" type = "button" 
								onclick = "function dec(){
												document.getElementById('<?php echo $idname1; ?>').stepDown();
												if(document.getElementById('<?php echo $idname1; ?>').value != '<?php echo $arr[$row["productname"]]; ?>'){
													document.getElementById('<?php echo $idname1; ?>').style.cssText = 'box-shadow: 0 0 0 4px #4A7C59;';
												}
												else{
													document.getElementById('<?php echo $idname1; ?>').style.cssText = 'box-shadow: none;';
												}
											}
											dec();"
											>-</button>
							<button class = "plus" id = "plus1" type = "button"
								onclick = "function inc(){
												document.getElementById('<?php echo $idname1; ?>').stepUp();
												if(document.getElementById('<?php echo $idname1; ?>').value != '<?php echo $arr[$row["productname"]]; ?>'){
													document.getElementById('<?php echo $idname1; ?>').style.cssText = 'box-shadow: 0 0 0 4px #4A7C59;';
												}
												else{
													document.getElementById('<?php echo $idname1; ?>').style.cssText = 'box-shadow: none;';
												}
											}
											inc();">+</button>
						</div>
						<hr>
						<?php
						$i++;
					}
				?>
		</div>
		<div class = "editq">
			<h3>Edit Price</h3>
			<hr id ="fhr">
				<?php
					$i  = 0;
					$res = $conn -> query($select);
					while($row = $res -> fetch_assoc()){
						$idname2 = "num2".strval($i);
						$temp_var2 = "b".$row["productname"];
						$arr2[$row["productname"]] = $row["price"];
						?>
						<div class = "filler">
							<input id = "<?php echo $idname2; ?>" type = "number"  name = "<?php echo $temp_var2; ?>" value = "<?php echo $row["price"]; ?>" min = 0>
							<button class = "minus" id = "minus2" type = "button"
								onclick = "function dec(){
												document.getElementById('<?php echo $idname2; ?>').stepDown();
												if(document.getElementById('<?php echo $idname2; ?>').value != '<?php echo $arr2[$row["productname"]]; ?>'){
													document.getElementById('<?php echo $idname2; ?>').style.cssText = 'box-shadow: 0 0 0 4px #4A7C59;';
												}
												else{
													document.getElementById('<?php echo $idname2; ?>').style.cssText = 'box-shadow: none;';
												}
											}
											dec();">-
							</button>
							<button class = "plus" id = "plus2" type = "button"
								onclick = "function inc(){
												document.getElementById('<?php echo $idname2; ?>').stepUp();
												if(document.getElementById('<?php echo $idname2; ?>').value != '<?php echo $arr2[$row["productname"]]; ?>'){
													document.getElementById('<?php echo $idname2; ?>').style.cssText = 'box-shadow: 0 0 0 4px #4A7C59;';
												}
												else{
													document.getElementById('<?php echo $idname2; ?>').style.cssText = 'box-shadow: none;';
												}
											}
											inc();">+
							</button>
						</div>
						<hr>
						<?php
						$i++;
					}
				?>
				
		</div>
		<div id = "float_form" style = "display: none;">
			<label id = "prodname">Product Name:</label>
			<input id = "prodname" type = "text" name = "prodname" value = "<?php echo $prodname;?>" > <span class = "error">* <?php echo $err;?> </span> <br>
			<label id = "quan">Quantity:</label> 
			<input id = "quan" type = "number" name = "quan" min = 0 value = "<?php echo $quan;?>"> <span class = "error">* <?php echo $err;?> </span> <br>
			<label id = "unit">Unit:</label> 
			<input id = "unit" type = "text" name = "unit" value = "<?php echo $unit;?>"> <span class = "error">* <?php echo $err;?> </span> <br>
			<label id = "price">Price:</label>  
			<input id = "price" type = "number" name = "price" min = 0 value = "<?php echo $price;?>"> <span class = "error">* <?php echo $err;?> </span> <br>
		</div>
		<input type = "submit" value = "Save" class = "save">
		</form>
	</div>
	<button type = "button" id = "show">Add Products</button>

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
	$on = mysqli_fetch_array($conn -> query("SELECT COUNT(*)
												FROM `credentials`
												WHERE `username` = '$_SESSION[usern]' AND `user_type` = 1"))[0];
	if($on == 0){
		?>
		<script type = "text/javascript">
			swal({
					title: "Unauthorized", 
					text: "You do not have market admin priviliges.", 
					icon: "error"
				})
				.then(function(){
					location.href = 'Research.php';
				});
		</script>
		<?php
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$res = $conn -> query($select);
		$i = $cnt = 0;
		if(empty($_POST["prodname"])){
			$cnt++;
		}
		else{
			$prodname = test_input($_POST["prodname"]);
		}
		if(empty($_POST["quan"])){
			$cnt++;
		}
		else{
			$quan = (double)$_POST["quan"];
		}
		if(empty($_POST["unit"])){
			$cnt++;
		}
		else{
			$unit = test_input($_POST["unit"]);
		}
		if(empty($_POST["price"])){
			$cnt++;
		}
		else{
			$price = (double) $_POST["price"];
		}
		if($cnt != 0 && $cnt != 4){
			$err = "This field is required";
		}
		$cnt = 0;
		if($err == ""){
			if($unit != ""){
				$cnt++;
				$insert = "INSERT INTO `market`
							(`productname`, `quantity`, `unit`, `price`, `market_name`)
							VALUES ('$prodname', '$quan', '$unit', '$price', '$_SESSION[market]')";
				$conn -> query($insert);
				echo $prodname." ".$quan." ".$price." ".$unit;																		 
			}
			while($row = $res -> fetch_assoc()){
				if($_POST["b".$row["productname"]] != $row["price"] || $_POST["a".$row["productname"]] != $row["quantity"]){
					$cnt++;
					$temp_var = $_POST["a".$row["productname"]];
					$update = "UPDATE `market` 
								SET `quantity` = '$temp_var' 
								WHERE `market_name` = '$_SESSION[market]' AND `productname` = '$row[productname]'";
					$conn -> query($update);
					$temp_var = $_POST["b".$row["productname"]];
					$update = "UPDATE `market` 
								SET `price` = '$temp_var' 
								WHERE `market_name` = '$_SESSION[market]' AND `productname` = '$row[productname]'";
					$conn -> query($update);
					
				}
				$i++;
			}

			if($cnt > 0){
				?>
				<script type = "text/javascript">
					swal({
						title: "Changes Saved", 
						text: "All changes have been saved", 
						icon: "success"
					})
					.then(function(){
						location.href = 'MarketEdit.php';
					});
				</script>
				<?php
			}
			else{
				?>
				<script type = "text/javascript">
					swal({
						title: "Invalid", 
						text: "None of the products have been changed", 
						icon: "error"
					})
					.then(function(){
						location.href = 'MarketEdit.php';
					});
				</script>
				<?php
			}

		}
	}
?>