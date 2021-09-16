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
					echo "<script type = text/javascript> 
						alert('Thank you for using our service!');
						location.href  = 'Cart.php';
					</script>";
				}
			}
		}
	}

?>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="Confirm_BuyCSS.css">
	<title>Transaction Confirmation</title>
</head>
<body>
	<h4>Insert "EVailable Goods header here (same nung sa Research.php)"</h4>
	<div id = "prod">
		<h3>You are about to make a legitimate transaction. An order will be made once you click the order button. All orders that have been already confirmed cannot be cancelled anymore. <br> For problems that may arise with regards to your order, the admins of this website are not liable for it, except in cases due to problems caused by our servers. <br> Below are the products you ordered:</h3>
		<?php
			$tot = 0;
			foreach ($_SESSION["buy_arr"] as $key => $value) {
				echo $value[1]."<br>Quantity: ".$value[0]." ".$value[4]."<br>Price: ".$value[3]."<br>Total Price: Php ".$value[3]*$value[0]."<br>From Market: ".$value[2]."<br><br>";
				$tot += $value[3]*$value[0];
			}
			echo "Total Amount to Pay: Php ".$tot;
		?>
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			Contact Number: <input type = "text" name = "contact" class = "field" value = "<?php echo $contact;?>"> <span class = "error">* <?php echo $contactErr;?></span> <br>
			Address/Location: <input type = "text" name = "add" class = "field" value = "<?php echo $add;?>"> <span class = "error">* <?php echo $addErr;?></span> <br>
			<input type = "submit" value = "Cancel" id = "cancel" name = "cancel">
			<input type = "submit" value = "Order" id = "order" name = "order">
		</form>
	</div>
</body>
</html>