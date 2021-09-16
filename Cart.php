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
	}
	if($checkchange > 0){
		echo "<script type = text/javascript> alert('Some products in your cart have quantities which are more than the maximum quantity available. We have already adjusted them for you!'); </script>";
	}
	if($checkzero > 0){
		echo "<script type = text/javascript> alert('Some products in your cart are out of stock. We have already removed them for you.'); </script>";
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
				echo "<script type = text/javascript> 
						alert('You will now be redirected to the confirmation page.');
						location.href  = 'Confirm_Buy.php';
					</script>";
			}
			else{
				$_SESSION["buy_arr"] = array();
				echo "<script type = text/javascript> alert('Invalid Details!'); </script>";
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
			echo "<script type = text/javascript> alert('All selected products have been removed!'); </script>";
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
			echo "<script type = text/javascript> alert('All products have been saved!'); </script>";
		}
	}

?>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="CartCSS.css">
	<title></title>
</head>
<body>
	<h4>Insert "EVailable Goods header here (same nung sa Research.php)"</h4>
	<div id = "items">
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
					echo "\n";
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
					echo "\n\t\t\t";
					echo "<input type = checkbox id = formID name = $idn>\n\t\t\t\t".
							"<label for = $idn>".$row["productname"]."</label>\n\t\t\t\t".
							"<div class = orderq>"."Quantity: "."<p id = $uni>$row[order_quantity]</p>"." ".$row["unit"]." ".
							"<button type = button onclick = \"
								function dec(){
									if(arr['$temp'] > 0){
										document.getElementById('$num').value = document.getElementById('$uni').innerHTML = --arr['$temp'];
									}
								}	
								dec();
							\">-</button>
							<button type = button onclick = \"
								function inc(){
									if(arr['$temp'] < '$arr_max[$i]'){
										document.getElementById('$num').value = document.getElementById('$uni').innerHTML = ++arr['$temp'];
									}
								}	
								inc();
							\">+</button>\n\t\t\t\t".
							"</div>\n\t\t\t\t".
							"<input type = hidden id = $num name = $num value = $row[order_quantity]>\n\t\t\t\t".
							"<input type = hidden name = $pro value = $row[productname]>\n\t\t\t\t".
							"<input type = hidden name = $mar_roxas value = $row[market]>\n\t\t\t\t".
							"<input type = hidden name = $pr value = $row[price]>\n\t\t\t\t".
							"<input type = hidden name = $un value = $row[unit]>\n\t\t\t\t".
							"<div class = priceid>"."Price: ".$row["price"]."</div>\n\t\t\t\t".
							"<div class = fmarket>"."From: ".$row["market"]."</div>".
						"\n\t\t\t";
					$i++;
				}
				echo "\n";
			?>
			<input type = "submit" value = "Remove" id = "remove" name = "remove">
			<input type = "submit" value = "Save" id = "save" name = "save">
			<input type = "submit" value = "Buy Now" id = "buynow" name = "buy">
			
		</form>
	</div>
	<!--
		Insert nav sht here, yung may Buy Edit Talk (same sa lahat ng page)
	-->
</body>
</html>