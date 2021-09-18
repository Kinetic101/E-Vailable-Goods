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
				echo "<script type = text/javascript>
						alert('All changes have been saved.'); 
						location.href = 'MarketEdit.php';
					</script>";
			}
			else{
				echo "<script type = text/javascript>
						alert('No products have been changed.'); 
						location.href = 'MarketEdit.php';
					</script>";
			}
		}
	}
?>
<script type="text/javascript">
	function magic(){
		var x = document.getElementById('float_form');
		if(x.style.display == 'none'){
			x.style.display = 'block';
		}
		else{
			x.style.display = 'none';
		}
	}
</script>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="MarketEditCSS.css">
	<title><?php echo $_SESSION["market"]?> Edit</title>

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
					echo "<div class = filler>".$row["productname"]."</div>\n\t\t\t"."<hr>\n\t\t\t";
				}
				echo"\n";
			?>
		</div>

		<div class = "quantity">
			<h3>Quantity</h3>
			<hr id ="fhr">
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
			<hr id ="fhr">
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
			<hr id ="fhr">
			<?php
				$res = $conn -> query($select);
				while($row = $res->fetch_assoc()) {
					echo "<div class = filler>".$row["price"]."</div>\n\t\t\t"."<hr>\n\t\t\t";
				}
				echo"\n";
			?>
		</div>
		<div class = "editp">
			<h3>Edit Quantity</h3>
			<hr id ="fhr">
			<form method = post action = <?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>>
				<?php
					$i  = 0;
					$res = $conn -> query($select);
					while($row = $res -> fetch_assoc()){
						$idname1 = "num1".strval($i);
						$temp_var1 = "a".$row["productname"];
						echo "<div class = filler>\n\t\t\t\t\t"."<input id = $idname1 type = number name = $temp_var1 value = $row[quantity] min = 0>
						<button id = minus type = button onclick = \"
							function dec(){
								document.getElementById('$idname1').stepDown();
							} 
							dec();\" >-</button>
						<button id = plus type = button onclick = \"
							function inc(){
								document.getElementById('$idname1').stepUp();
							} 
							inc();\">+</button>\n\t\t\t\t"
						."</div>\n\t\t\t\t"
						."<hr>\n\t\t\t\t";
						$i++;
					}
					echo "\n";
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
						echo "<div class = filler>\n\t\t\t\t\t"."<input id = $idname2 type = number name = $temp_var2 value = $row[price] min = 0>
						<button id = minus type = button onclick = \"
							function dec(){
								document.getElementById('$idname2').stepDown();
							} 
							dec();\" >-</button>
						<button id = plus type = button onclick = \"
							function inc(){
								document.getElementById('$idname2').stepUp();
							} 
							inc();\">+</button>\n\t\t\t\t"
						."</div>\n\t\t\t\t"
						."<hr>\n\t\t\t\t";
						$i++;
					}
					echo "\n";
				?>
				
		</div>
		<div id = "float_form" style = "display: block;">
			<label id = "prodname">Product Name:</label> <input id = "prodname" type = "text" name = "prodname" value = <?php echo $prodname;?> > <span class = "error">* <?php echo $err;?> </span> <br>
			<label id = "quan">Quantity:</label> <input id = "quan" type = "number" name = "quan" min = 0 value = <?php echo $quan;?>> <span class = "error">* <?php echo $err;?> </span> <br>
			<label id = "unit">Unit:</label> <input id = "unit" type = "text" name = "unit" value = <?php echo $unit;?>> <span class = "error">* <?php echo $err;?> </span> <br>
			<label id = "price">Price:</label>  <input id = "price" type = "number" name = "price" min = 0 value = <?php echo $price;?>> <span class = "error">* <?php echo $err;?> </span> <br>
			
		</div>
		<input type = "submit" value = "Save" class = "save">
		</form>
	</div>
	<button type = "button" onclick="magic()" class = "show">Add Products</button>
</body>
</html>