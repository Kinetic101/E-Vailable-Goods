<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["admin"] == ''){
		header("Location: Login.php");
	}

	else if($_SESSION["market"] == ""){
		header("Location: Edit.php");
	}


	if($_SESSION["admin"] == ""){
		header("Location: Login.php");
	}

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname_user = "user";
	$dbname_admin = "admin";
	$conn_user = new mysqli($server, $usname, $pass, $dbname_user);
	$conn_admin = new mysqli($server, $usname, $pass, $dbname_admin);
	if($conn_user -> connect_error){
		die("Connection Failed: ".$conn_user -> connect_error);
	}
	if($conn_admin -> connect_error){
		die("Connection Failed: ".$conn_admin -> connect_error);
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

	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel = "stylesheet" href = "MarketEditCSS.css"> 
	<link rel="stylesheet" type="text/css" href="NavBarCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="NavBarJS.js"></script>
	<script type="text/javascript" src="MarketEditJS.js"></script>
	<title><?php echo $_SESSION["market"]?> Edit</title>

</head>	
<body>
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
	                <li class="nav-item">
	                    <a class="nav-link" href="Orders.php"><i class="fas fa-clipboard-list"></i>Orders</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Messages.php"><i class="fas fa-inbox"></i>Messages</a>
	                </li>
	                <li class="nav-item active">
	                    <a class="nav-link" href="Edit.php"><i class="fas fa-edit"></i>Edit</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Logout.php"><i class="fas fa-sign-out-alt"></i>Log Out</a>
	                </li>
	            </ul>
	        </div>
	    </nav>
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
				$res = $conn_user -> query($select);
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
				$res = $conn_user -> query($select);
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
				$res = $conn_user -> query($select);
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
				$res = $conn_user -> query($select);
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
					$res = $conn_user -> query($select);
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
							<script type="text/javascript">
								function check_vals(){
									if(document.getElementById('<?php echo $idname1; ?>').value != '<?php echo $arr[$row["productname"]]; ?>'){
										document.getElementById('<?php echo $idname1; ?>').style.cssText = 'box-shadow: 0 0 0 4px #4A7C59;';
									}
									else{
										document.getElementById('<?php echo $idname1; ?>').style.cssText = 'box-shadow: none;';
									}
								}
								setInterval(check_vals, 10);
							</script>
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
					$res = $conn_user -> query($select);
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
											}
											dec();">-
							</button>
							<button class = "plus" id = "plus2" type = "button"
								onclick = "function inc(){
												document.getElementById('<?php echo $idname2; ?>').stepUp();
											}
											inc();">+
							</button>
							<script type="text/javascript">
								function check_vals(){
									if(document.getElementById('<?php echo $idname2; ?>').value != '<?php echo $arr2[$row["productname"]]; ?>'){
										document.getElementById('<?php echo $idname2; ?>').style.cssText = 'box-shadow: 0 0 0 4px #4A7C59;';
									}
									else{
										document.getElementById('<?php echo $idname2; ?>').style.cssText = 'box-shadow: none;';
									}
								}
								setInterval(check_vals, 10);
							</script>
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
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$res = $conn_user -> query($select);
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
				$conn_user -> query($insert);
				echo $prodname." ".$quan." ".$price." ".$unit;																		 
			}
			while($row = $res -> fetch_assoc()){
				if($_POST["b".$row["productname"]] != $row["price"] || $_POST["a".$row["productname"]] != $row["quantity"]){
					$cnt++;
					$temp_var = $_POST["a".$row["productname"]];
					$update = "UPDATE `market` 
								SET `quantity` = '$temp_var' 
								WHERE `market_name` = '$_SESSION[market]' AND `productname` = '$row[productname]'";
					$conn_user -> query($update);
					$temp_var = $_POST["b".$row["productname"]];
					$update = "UPDATE `market` 
								SET `price` = '$temp_var' 
								WHERE `market_name` = '$_SESSION[market]' AND `productname` = '$row[productname]'";
					$conn_user -> query($update);
					
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