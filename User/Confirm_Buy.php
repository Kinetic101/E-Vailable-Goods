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
	$_SESSION["author"] = 0;

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
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order"])){
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
		}
	}
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cancel"])){
		header("Location: Cart.php");
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
	<link rel="stylesheet" type="text/css" href="SearchCSS.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="Confirm_BuyJS.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="SearchJS.js"></script>
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
				<li class="search-bar">
					<input type="text" placeholder="Search for others" class="inp">
					<i class="fas fa-search"></i>
					<div id="sres">
						<?php
						$select = "SELECT `username`, `fname`, `lname`, `pic`
									FROM `credentials`
									WHERE `username` != '$_SESSION[usern]'
									ORDER BY `username` ASC";
						$res = $conn -> query($select);
						while($row = $res -> fetch_assoc()){
							?>
							<a href = "Reroute(Dashboard_to_VisitUser).php?user=<?php echo $row["username"]; ?>">
								<div class = "chaturc"><img src="<?php echo $row["pic"]; ?>" id="chatur" style="width:40px;height:40px"></div>
								<h5>
								<?php echo $row["fname"]." ".$row["lname"]; ?>
								</h5>
							</a>
							<?php
						}
						?>
					</div>
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
		<hr id = "fhr">
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
		</div>

		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div id = "cins" style="display:none">
				<label for = "contact">Contact Number </label><span class = "error">* <?php echo $contactErr;?></span>
				<input placeholder="ex. 09*********"type = "text" name = "contact" class = "field" id = "cn" value = "<?php echo $contact;?>"> 
				<label for = "town">Town/Municipality </label><span class = "error">* </span>
				<select name = "town" id = "town" autocomplete="off">
					<option value = "caramoan">Caramoan</option>
					<option value = "garchitorena">Garchitorena</option>
					<option value = "goa">Goa</option>
					<option value = "lagonoy">Lagonoy</option>
					<option value = "presentacion">Presentacion</option>
					<option value = "sagnay">Sagnay</option>
					<option value = "sjose">San Jose</option>
					<option value = "siruma">Siruma</option>
					<option value = "tigaon">Tigaon</option>
					<option value = "tinambac">Tinambac</option>
				</select>
				<label for = "brgy">Barangay </label><span class = "error">* </span>
				<input list = "caramoan_list" type="text" id = "bry" placeholder = "ex. Agaas" autocomplete="off">
				<datalist id = "caramoan_list" style="height:5.1em;overflow:hidden">
						<!-- Start of Caramoan Barangays -->
					<option value = "Agaas">
					<option value = "Antolon">
					<option value = "Bacgong">
					<option value = "Bahay">
					<option value = "Bikal">
					<option value = "Binanuahan">
					<option value = "Cabacongan">
					<option value = "Cadong">
					<option value = "Canatuan">
					<option value = "Caputatan">
					<option value = "Calongcogong">
					<option value = "Daraga">
					<option value = "Gata">
					<option value = "Gibgos">
					<option value = "Gogon">
					<option value = "Guijalo">
					<option value = "Hanopol">
					<option value = "Hanoy">
					<option value = "Haponan">
					<option value = "Ilawod">
					<option value = "Ili-Centro">
					<option value = "Lidong">
					<option value = "Lubas">
					<option value = "Malabog">
					<option value = "Maligaya">
					<option value = "Mampirao">
					<option value = "Mandiclum">
					<option value = "Maqueda">
					<option value = "Minalaba">
					<option value = "Oring">
					<option value = "Oroc-Osoc">
					<option value = "Pagolinan">
					<option value = "Pandanan">
					<option value = "Paniman">
					<option value = "Patag-Belen">
					<option value = "Pili-Centro">
					<option value = "Pili-Tabiguian">
					<option value = "Poloan">
					<option value = "Salvacion">
					<option value = "San Roque">
					<option value = "San Vicente">
					<option value = "Santa Cruz">
					<option value = "Solnopan">
					<option value = "Tabgon">
					<option value = "Tabiguian">
					<option value = "Tabog">
					<option value = "Tawog">
					<option value = "Terogo">
					<option value = "Toboan">
						<!-- End of Caramoan Barangays -->
						<!-- Start of Garchitorena Barangays -->
					<option value = "Ason">
					<option value = "Bahi">
					<option value = "Barangay I">
					<option value = "Barangay II">
					<option value = "Barangay III">
					<option value = "Barangay IV">
					<option value = "Binagasbasan">
					<option value = "Burabod">
					<option value = "Cagamutan">
					<option value = "Cagnipa">
					<option value = "Canlong">
					<option value = "Dangla">
					<option value = "Del Pilar">
					<option value = "Denrica">
					<option value = "Harrison">
					<option value = "Mansangat">
					<option value = "Pambuhan">
					<option value = "Sagrada">
					<option value = "Salvacion">
					<option value = "San Vicente">
					<option value = "Sumaoy">
					<option value = "Tamiawon">
					<option value = "Toytoy">
						<!-- End of Garchitorena Barangays -->
						<!-- Start of Goa Barangays -->
					<option value = "Abucayan">
					<option value = "Bagumbayan Grande">
					<option value = "Bagumbayan Pequeño">
					<option value = "Balaynan">
					<option value = "Belen">
					<option value = "Buyo">
					<option value = "Cagaycay">
					<option value = "Catagbacan">
					<option value = "Digdigon">
					<option value = "Gimaga">
					<option value = "Halawig-Gogon">
					<option value = "Hiwacloy">
					<option value = "La Purisima">
					<option value = "Lamon">
					<option value = "Matacla">
					<option value = "Maymatan">
					<option value = "Maysalay">
					<option value = "Napawon">
					<option value = "Panday">
					<option value = "Payatan">
					<option value = "Pinaglabanan">
					<option value = "Salog">
					<option value = "San Benito">
					<option value = "San Isidro">
					<option value = "San Isidro West">
					<option value = "San Jose">
					<option value = "San Juan Bautista">
					<option value = "San Juan Evangelista">
					<option value = "San Pedro">
					<option value = "Scout Fuentebella">
					<option value = "Tabgon">
					<option value = "Tagongtong">
					<option value = "Tamban">
					<option value = "Taytay">
						<!-- End of Goa Barangays -->
						<!-- Start of Lagonoy Barangays -->
					<option value = "Agosais">
					<option value = "Agpo-Camagong-Tabog">
					<option value = "Amoguis">
					<option value = "Balaton">
					<option value = "Binanuahan">
					<option value = "Bocogan">
					<option value = "Burabod">
					<option value = "Cabotonan">
					<option value = "Dahat">
					<option value = "Del Carmen">
					<option value = "Gimagtocon">
					<option value = "Ginorangan">
					<option value = "Gubat">
					<option value = "Guibahoy">
					<option value = "Himanag">
					<option value = "Kinahologan">
					<option value = "Loho">
					<option value = "Manamoc">
					<option value = "Mangogon">
					<option value = "Mapid">
					<option value = "Olas">
					<option value = "Omalo">
					<option value = "Panagan">
					<option value = "Panicuan">
					<option value = "Pinamihagan">
					<option value = "San Fancisco">
					<option value = "San Isidro">
					<option value = "San Isidro Norte">
					<option value = "San Isidro Sur">
					<option value = "San Rafael">
					<option value = "San Ramon">
					<option value = "San Roque">
					<option value = "San Sebastian">
					<option value = "San Vicente">
					<option value = "Santa Cruz">
					<option value = "Santa Maria">
					<option value = "Saripongpong">
					<option value = "Sipaco">
						<!-- End of Lagonoy Barangays -->
						<!-- Start of Presentacion Barangays -->
					<option value = "Ayugao">
					<option value = "Bagong Sirang">
					<option value = "Baliguian">
					<option value = "Bantugan">
					<option value = "Bicalen">
					<option value = "Bitaogan">
					<option value = "Buenavista">
					<option value = "Bulalacao">
					<option value = "Cagnipa">
					<option value = "Lagha">
					<option value = "Lidong">
					<option value = "Liwacsa">
					<option value = "Maangas">
					<option value = "Pagsangahan">
					<option value = "Patrocinio">
					<option value = "Pili">
					<option value = "Santa Maria">
					<option value = "Tanawan">
						<!-- End of Presentacion Barangays -->
						<!-- Start of Sagnay Barangays -->
					<option value = "Aniog">
					<option value = "Atulayan">
					<option value = "Bongalon">
					<option value = "Buracan">
					<option value = "Catalotoan">
					<option value = "Del Carmen">
					<option value = "Kilantaao">
					<option value = "Kilomaon">
					<option value = "Mabca">
					<option value = "Minadongjol">
					<option value = "Nato">
					<option value = "Patitinan">
					<option value = "San Antonio">
					<option value = "San Isidro">
					<option value = "San Roque">
					<option value = "Santo Niño">
					<option value = "Sibaguan">
					<option value = "Tinorongan">
					<option value = "Turague">
						<!-- End of Sagnay Barangays -->
						<!-- Start of San Jose Barangays -->
					<option value = "Adiangao">
					<option value = "Bagacay">
					<option value = "Bahay">
					<option value = "Boclod">
					<option value = "Calalahan">
					<option value = "Calawit">
					<option value = "Camagong">
					<option value = "Catalotoan">
					<option value = "Danlog">
					<option value = "Del Carmen">
					<option value = "Dolo">
					<option value = "Kinalansan">
					<option value = "Mampirao">
					<option value = "Manzana">
					<option value = "Minoro">
					<option value = "Palale">
					<option value = "Ponglon">
					<option value = "Pugay">
					<option value = "Sabang">
					<option value = "Salogon">
					<option value = "San Antonio">
					<option value = "San Juan">
					<option value = "San Vicente">
					<option value = "Santa Cruz">
					<option value = "Soledad">
					<option value = "Tagas">
					<option value = "Tambangan">
					<option value = "Telegrafo">
					<option value = "Tominawog">
						<!-- End of San Jose Barangays -->
						<!-- Start of Siruma Barangays -->
					<option value = "Bagong Sirang">
					<option value = "Bahao">
					<option value = "Boboan">
					<option value = "Butawanan">
					<option value = "Cabugao">
					<option value = "Fundado">
					<option value = "Homestead">
					<option value = "La Purisima">
					<option value = "Mabuhay">
					<option value = "Malaconini">
					<option value = "Matandang Siruma">
					<option value = "Nalayahan">
					<option value = "Pamintan-Bantilan">
					<option value = "Pinitan">
					<option value = "Poblacion">
					<option value = "Salvacion">
					<option value = "San Andres">
					<option value = "San Ramon">
					<option value = "Sulpa">
					<option value = "Tandoc">
					<option value = "Tongo-Bantigue">
					<option value = "Vito">
						<!-- End of Siruma Barangays -->
						<!-- Start of Tigaon Barangays -->
					<option value = "Abo">
					<option value = "Cabalinadan">
					<option value = "Caraycayon">
					<option value = "Casuna">
					<option value = "Consocep">
					<option value = "Coyaoyao">
					<option value = "Gaao">
					<option value = "Gingaroy">
					<option value = "Gubat">
					<option value = "Huyonhuyon">
					<option value = "Libod">
					<option value = "Mabalodbalod">
					<option value = "May-Anao">
					<option value = "Panagan">
					<option value = "Poblacion">
					<option value = "Salvacion">
					<option value = "San Antonio">
					<option value = "San Francisco">
					<option value = "San Miguel">
					<option value = "San Rafael">
					<option value = "Talojongon">
					<option value = "Tinawagan">
					<option value = "Vinagre">
						<!-- End of Tigaon Barangays -->
						<!-- Start of Tinambac Barangays -->
					<option value = "Agay-Ayan">
					<option value = "Antipolo">
					<option value = "Bagacay">
					<option value = "Banga">
					<option value = "Bani">
					<option value = "Bataan">
					<option value = "Binalay">
					<option value = "Bolaobalite">
					<option value = "Buenavista">
					<option value = "Buyo">
					<option value = "Cagliliog">
					<option value = "Caloco">
					<option value = "Camagong">
					<option value = "Canayonan">
					<option value = "Cawaynan">
					<option value = "Daligan">
					<option value = "Filarca">
					<option value = "La Medalla">
					<option value = "La Purisima">
					<option value = "Lupi">
					<option value = "Magsaysay">
					<option value = "Magtang">
					<option value = "Mananao">
					<option value = "New Caaluan">
					<option value = "Olag Grande">
					<option value = "Olag Pequeño">
					<option value = "Old Caaluan">
					<option value = "Pag-asa">
					<option value = "Pantat">
					<option value = "Sagrada">
					<option value = "Salvacion">
					<option value = "Salvacion Poblacion">
					<option value = "San Antonio">
					<option value = "San Isidro">
					<option value = "San Jose">
					<option value = "San Pascual">
					<option value = "San Ramon">
					<option value = "San Roque">
					<option value = "San Vicente">
					<option value = "Santa Cruz">
					<option value = "Sogod">
					<option value = "Tambang">
					<option value = "Tierra Nevada">
					<option value = "Union">
						<!-- End of Tinambac Barangays -->
				</datalist>
				<label for = "street">Street Address </label><span class = "error">* </span>
				<input placeholder="ex. San Isidro Street" type = "text" name = "street" class = "field" id = "st" value = ""> 
				
			</div>
			<div class = "butts">
			<input type = "submit" value = "Cancel" id = "cancel" name = "cancel">
			<input type = "submit" value = "Order" id = "order" name = "order">
			</div>
		</form>
			<button type = "button" id = "show">Set Address <i class="fas fa-chevron-right"></i> </button>
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
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order"])){
		if($input){
			if(!$error){
				$date = date("Y-m-d H:i:s");
				$n = mysqli_fetch_array($conn -> query("SELECT COUNT(DISTINCT(`id`))
															FROM `orders`"))[0]+1;
				foreach($_SESSION["buy_arr"] as $key => $value){
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

					$insert = "INSERT INTO `orders`
								(`id`, `username`, `productname`, `order_quantity`, `unit`, `price_as_of_order`, `market`, `address`, `contact`, `date_time`, `state`)
								VALUES ('$n', '$_SESSION[usern]', '$prod', '$ordr', '$unit', '$pric', '$mark', '$add', '$contact', '$date', 0)";
					$conn -> query($insert);

				}
				//Notify user

				$p = mysqli_fetch_array($conn -> query("SELECT COUNT(*) 
														FROM `notifications`"))[0]+1;
				$title = "Your order with ID#".$n." has been confirmed";
				$msg = "Your order with ID#".$n." has been confirmed, we will keep in touch with you by continuously updating you reagarding its status. You may receive an email or SMS regarding its updates. Thank you!";
				$insert = "INSERT INTO `notifications`
							(`id`, `username`, `notif_title`, `notif_msg`, `unread`)
							VALUES ('$p', '$_SESSION[usern]', '$title', '$msg', 1)";
				$conn -> query($insert);
				$_SESSION["buy_arr"] = [];
				?>
				<script type = "text/javascript"> 
					swal({
						title: "Order Confirmed!", 
						text: "Thank you for using our service!", 
						icon: "success"
					})
					.then(function(){
						location.href = "Cart.php";
					});
				</script>
				<?php
			}
		}
	}
?>