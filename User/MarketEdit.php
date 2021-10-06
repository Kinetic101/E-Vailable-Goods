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
	$admin = new mysqli($server, $usname, $pass, "admin");
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}
	if($admin -> connect_error){
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
	<link rel="stylesheet" type="text/css" href="SearchCSS.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/f463b44b8d.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="MarketEditJS.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="SearchJS.js"></script>
	<title><?php echo $_SESSION["market"]?> Edit</title>

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
					<div class = "filler">Php <?php echo $row["price"]; ?></div>
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
							<input id = "<?php echo $idname1; ?>" type = "number"  name = "<?php echo $temp_var1; ?>" value = "<?php echo $row["quantity"]; ?>" min = 0 
								onchange = "check_vals('<?php echo $idname1; ?>', '<?php echo $arr[$row["productname"]]; ?>'); ">
							<button class = "minus" id = "minus1" type = "button" onclick = "dec('<?php echo $idname1; ?>', '<?php echo $arr[$row["productname"]]; ?>');">-</button>
							<button class = "plus" id = "plus1" type = "button" onclick = "inc('<?php echo $idname1; ?>', '<?php echo $arr[$row["productname"]]; ?>');">+</button>
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
							<input id = "<?php echo $idname2; ?>" type = "number"  name = "<?php echo $temp_var2; ?>" value = "<?php echo $row["price"]; ?>" min = 0 
								onchange = "check_vals('<?php echo $idname2; ?>', '<?php echo $arr2[$row["productname"]]; ?>'); ">
							<button class = "minus" id = "minus2" type = "button" onclick = "dec('<?php echo $idname2; ?>', '<?php echo $arr2[$row["productname"]]; ?>');">-</button>
							<button class = "plus" id = "plus2" type = "button" onclick = "inc('<?php echo $idname2; ?>', '<?php echo $arr2[$row["productname"]]; ?>');">+</button>
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

</body>
</html>
<?php 
	if(isset($_GET["market"])){
		$ok = 0;
		if($_GET["market"] == "market1"){
			$select = "SELECT `m1`
						FROM `credentials`
						WHERE `username` = '$_SESSION[usern]'";
			$res = $conn -> query($select);
			while($row = $res -> fetch_assoc()){
				$ok = $row["m1"];
			}
		}
		else if($_GET["market"] == "market2"){
			$select = "SELECT `m2`
						FROM `credentials`
						WHERE `username` = '$_SESSION[usern]'";
			$res = $conn -> query($select);
			while($row = $res -> fetch_assoc()){
				$ok = $row["m2"];
			}		
		}
		else if($_GET["market"] == "market3"){
			$select = "SELECT `m3`
						FROM `credentials`
						WHERE `username` = '$_SESSION[usern]'";
			$res = $conn -> query($select);
			while($row = $res -> fetch_assoc()){
				$ok = $row["m3"];
			}
		}
		else if($_GET["market"] == "market4"){
			$select = "SELECT `m4`
						FROM `credentials`
						WHERE `username` = '$_SESSION[usern]'";
			$res = $conn -> query($select);
			while($row = $res -> fetch_assoc()){
				$ok = $row["m4"];
			}		
		}
		else if($_GET["market"] == "market5"){
			$select = "SELECT `m5`
						FROM `credentials`
						WHERE `username` = '$_SESSION[usern]'";
			$res = $conn -> query($select);
			while($row = $res -> fetch_assoc()){
				$ok = $row["m5"];
			}		
		}
		else if($_GET["market"] == "market6"){
			$select = "SELECT `m6`
						FROM `credentials`
						WHERE `username` = '$_SESSION[usern]'";
			$res = $conn -> query($select);
			while($row = $res -> fetch_assoc()){
				$ok = $row["m6"];
			}		
		}
		if($ok == 1){
			?>
			<script type="text/javascript">
				location.href = "MarketEdit.php";
			</script>
			<?php
		}
		else{
			?>
			<script type="text/javascript">
				swal({
					title: "Unauthorized Access", 
					text: "You are currently unauthorized to access this market's editing page, please contact the website administrators to get access.", 
					icon: "error"
				})
				.then(function(){
					location.href = 'Help_and_Support.php';
				});
			</script>
			<?php
		}
	}
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
			$date = date("Y-m-d H:i:s");
			while($row = $res -> fetch_assoc()){
				if($_POST["b".$row["productname"]] != $row["price"] || $_POST["a".$row["productname"]] != $row["quantity"]){
					$cnt++;
					$newq = $_POST["a".$row["productname"]];
					$update = "UPDATE `market` 
								SET `quantity` = '$newq' 
								WHERE `market_name` = '$_SESSION[market]' AND `productname` = '$row[productname]'";
					$conn -> query($update);
					$newp = $_POST["b".$row["productname"]];
					$update = "UPDATE `market` 
								SET `price` = '$newp' 
								WHERE `market_name` = '$_SESSION[market]' AND `productname` = '$row[productname]'";
					$conn -> query($update);
					$add = "INSERT INTO `edit_logs`
							(`productname`, `market`, `username`, `oquantity`, `nquantity`, `unit`, `oprice`, `nprice`, `time`)
							VALUES ('$row[productname]', '$_SESSION[market]', '$_SESSION[usern]', '$row[quantity]', '$newq', '$row[unit]', '$row[price]', '$newp', '$date')";
					$admin -> query($add);
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