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

	$contact = $add = $town = $brgy = "";
	$contactErr = $addErr = $townErr = $brgyErr = "";
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
				if(strlen($contact) == 11){
					if($contact[0] != '0' || $contact[1] != '9'){
						$contactErr = "Invalid contact number!";
						$error = true;
					}
				}
				else if(strlen($contact) == 13){
					if($contact[0] != '+' || $contact[1] != '6'){
						$contactErr = "Invalid contact number!";
						$error = true;
					}
				}
				else{
					$contactErr = "Invalid contact number!";
					$error = true;
				}
			}
			if($_POST["town"] == 0){
				$error = True;
				$townErr = "Town/Municipality cannot be empty!";
			}
			else{
				if($_POST["town"] == 1){
					$town = "Caramoan";
				}
				else if($_POST["town"] == 2){
					$town = "Garchitorena";
				}
				else if($_POST["town"] == 3){
					$town = "Goa";
				}
				else if($_POST["town"] == 4){
					$town = "Lagonoy";
				}
				else if($_POST["town"] == 5){
					$town = "Presentacion";
				}
				else if($_POST["town"] == 6){
					$town = "Sagnay";
				}
				else if($_POST["town"] == 7){
					$town = "San Jose";
				}
				else if($_POST["town"] == 8){
					$town = "Siruma";
				}
				else if($_POST["town"] == 9){
					$town = "Tigaon";
				}
				else if($_POST["town"] == 10){
					$town = "Tinambac";
				}
			}
			if(empty($_POST["brgy"]) || $_POST["brgy"] == "---Select Municipality First---"){
				$error = True;
				$brgyErr = "Barangay cannot be empty!";
			}
			else{
				$brgy = $_POST["brgy"];
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
				<label for = "town">Town/Municipality </label><span class = "error">* <?php echo $townErr;?></span>
				<select name = "town" id = "town" autocomplete="off">
					<option value = "0">---Select Municipality---</option>
					<option value = "1">Caramoan</option>
					<option value = "2">Garchitorena</option>
					<option value = "3">Goa</option>
					<option value = "4">Lagonoy</option>
					<option value = "5">Presentacion</option>
					<option value = "6">Sagnay</option>
					<option value = "7">San Jose</option>
					<option value = "8">Siruma</option>
					<option value = "9">Tigaon</option>
					<option value = "10">Tinambac</option>
				</select>
				<label for = "brgy">Barangay </label><span class = "error">* <?php echo $brgyErr;?></span>
				<input list = "brgy_list" type="text" id = "bry" name="brgy" placeholder = "ex. Agaas" autocomplete="off">
				<datalist id = "brgy_list" style="height:5.1em;overflow:hidden">
					<option value="---Select Municipality First---" class="a0">
						<!-- Start of Caramoan Barangays -->
					<option value = "Agaas" class="a1">
					<option value = "Antolon" class="a1">
					<option value = "Bacgong" class="a1">
					<option value = "Bahay" class="a1">
					<option value = "Bikal" class="a1">
					<option value = "Binanuahan" class="a1">
					<option value = "Cabacongan" class="a1">
					<option value = "Cadong" class="a1">
					<option value = "Canatuan" class="a1">
					<option value = "Caputatan" class="a1">
					<option value = "Calongcogong" class="a1">
					<option value = "Daraga" class="a1">
					<option value = "Gata" class="a1">
					<option value = "Gibgos" class="a1">
					<option value = "Gogon" class="a1">
					<option value = "Guijalo" class="a1">
					<option value = "Hanopol" class="a1">
					<option value = "Hanoy" class="a1">
					<option value = "Haponan" class="a1">
					<option value = "Ilawod" class="a1">
					<option value = "Ili-Centro" class="a1">
					<option value = "Lidong" class="a1">
					<option value = "Lubas" class="a1">
					<option value = "Malabog" class="a1">
					<option value = "Maligaya" class="a1">
					<option value = "Mampirao" class="a1">
					<option value = "Mandiclum" class="a1">
					<option value = "Maqueda" class="a1">
					<option value = "Minalaba" class="a1">
					<option value = "Oring" class="a1">
					<option value = "Oroc-Osoc" class="a1">
					<option value = "Pagolinan" class="a1">
					<option value = "Pandanan" class="a1">
					<option value = "Paniman" class="a1">
					<option value = "Patag-Belen" class="a1">
					<option value = "Pili-Centro" class="a1">
					<option value = "Pili-Tabiguian" class="a1">
					<option value = "Poloan" class="a1">
					<option value = "Salvacion" class="a1">
					<option value = "San Roque" class="a1">
					<option value = "San Vicente" class="a1">
					<option value = "Santa Cruz" class="a1">
					<option value = "Solnopan" class="a1">
					<option value = "Tabgon" class="a1">
					<option value = "Tabiguian" class="a1">
					<option value = "Tabog" class="a1">
					<option value = "Tawog" class="a1">
					<option value = "Terogo" class="a1">
					<option value = "Toboan" class="a1">
						<!-- End of Caramoan Barangays -->
						<!-- Start of Garchitorena Barangays -->
					<option value = "Ason" class="a2">
					<option value = "Bahi" class="a2">
					<option value = "Barangay I" class="a2">
					<option value = "Barangay II" class="a2">
					<option value = "Barangay III" class="a2">
					<option value = "Barangay IV" class="a2">
					<option value = "Binagasbasan" class="a2">
					<option value = "Burabod" class="a2">
					<option value = "Cagamutan" class="a2">
					<option value = "Cagnipa" class="a2">
					<option value = "Canlong" class="a2">
					<option value = "Dangla" class="a2">
					<option value = "Del Pilar" class="a2">
					<option value = "Denrica" class="a2">
					<option value = "Harrison" class="a2">
					<option value = "Mansangat" class="a2">
					<option value = "Pambuhan" class="a2">
					<option value = "Sagrada" class="a2">
					<option value = "Salvacion" class="a2">
					<option value = "San Vicente" class="a2">
					<option value = "Sumaoy" class="a2">
					<option value = "Tamiawon" class="a2">
					<option value = "Toytoy" class="a2">
						<!-- End of Garchitorena Barangays -->
						<!-- Start of Goa Barangays -->
					<option value = "Abucayan" class="a3">
					<option value = "Bagumbayan Grande" class="a3">
					<option value = "Bagumbayan Pequeño" class="a3">
					<option value = "Balaynan" class="a3">
					<option value = "Belen" class="a3">
					<option value = "Buyo" class="a3">
					<option value = "Cagaycay" class="a3">
					<option value = "Catagbacan" class="a3">
					<option value = "Digdigon" class="a3">
					<option value = "Gimaga" class="a3">
					<option value = "Halawig-Gogon" class="a3">
					<option value = "Hiwacloy" class="a3">
					<option value = "La Purisima" class="a3">
					<option value = "Lamon" class="a3">
					<option value = "Matacla" class="a3">
					<option value = "Maymatan" class="a3">
					<option value = "Maysalay" class="a3">
					<option value = "Napawon" class="a3">
					<option value = "Panday" class="a3">
					<option value = "Payatan" class="a3">
					<option value = "Pinaglabanan" class="a3">
					<option value = "Salog" class="a3">
					<option value = "San Benito" class="a3">
					<option value = "San Isidro" class="a3">
					<option value = "San Isidro West" class="a3">
					<option value = "San Jose" class="a3">
					<option value = "San Juan Bautista" class="a3">
					<option value = "San Juan Evangelista" class="a3">
					<option value = "San Pedro" class="a3">
					<option value = "Scout Fuentebella" class="a3">
					<option value = "Tabgon" class="a3">
					<option value = "Tagongtong" class="a3">
					<option value = "Tamban" class="a3">
					<option value = "Taytay" class="a3">
						<!-- End of Goa Barangays -->
						<!-- Start of Lagonoy Barangays -->
					<option value = "Agosais" class="a4">
					<option value = "Agpo-Camagong-Tabog" class="a4">
					<option value = "Amoguis" class="a4">
					<option value = "Balaton" class="a4">
					<option value = "Binanuahan" class="a4">
					<option value = "Bocogan" class="a4">
					<option value = "Burabod" class="a4">
					<option value = "Cabotonan" class="a4">
					<option value = "Dahat" class="a4">
					<option value = "Del Carmen" class="a4">
					<option value = "Gimagtocon" class="a4">
					<option value = "Ginorangan" class="a4">
					<option value = "Gubat" class="a4">
					<option value = "Guibahoy" class="a4">
					<option value = "Himanag" class="a4">
					<option value = "Kinahologan" class="a4">
					<option value = "Loho" class="a4">
					<option value = "Manamoc" class="a4">
					<option value = "Mangogon" class="a4">
					<option value = "Mapid" class="a4">
					<option value = "Olas" class="a4">
					<option value = "Omalo" class="a4">
					<option value = "Panagan" class="a4">
					<option value = "Panicuan" class="a4">
					<option value = "Pinamihagan" class="a4">
					<option value = "San Fancisco" class="a4">
					<option value = "San Isidro" class="a4">
					<option value = "San Isidro Norte" class="a4">
					<option value = "San Isidro Sur" class="a4">
					<option value = "San Rafael" class="a4">
					<option value = "San Ramon" class="a4">
					<option value = "San Roque" class="a4">
					<option value = "San Sebastian" class="a4">
					<option value = "San Vicente" class="a4">
					<option value = "Santa Cruz" class="a4">
					<option value = "Santa Maria" class="a4">
					<option value = "Saripongpong" class="a4">
					<option value = "Sipaco" class="a4">
						<!-- End of Lagonoy Barangays -->
						<!-- Start of Presentacion Barangays -->
					<option value = "Ayugao" class="a5">
					<option value = "Bagong Sirang" class="a5">
					<option value = "Baliguian" class="a5">
					<option value = "Bantugan" class="a5">
					<option value = "Bicalen" class="a5">
					<option value = "Bitaogan" class="a5">
					<option value = "Buenavista" class="a5">
					<option value = "Bulalacao" class="a5">
					<option value = "Cagnipa" class="a5">
					<option value = "Lagha" class="a5">
					<option value = "Lidong" class="a5">
					<option value = "Liwacsa" class="a5">
					<option value = "Maangas" class="a5">
					<option value = "Pagsangahan" class="a5">
					<option value = "Patrocinio" class="a5">
					<option value = "Pili" class="a5">
					<option value = "Santa Maria" class="a5">
					<option value = "Tanawan" class="a5">
						<!-- End of Presentacion Barangays -->
						<!-- Start of Sagnay Barangays -->
					<option value = "Aniog" class="a6">
					<option value = "Atulayan" class="a6">
					<option value = "Bongalon" class="a6">
					<option value = "Buracan" class="a6">
					<option value = "Catalotoan" class="a6">
					<option value = "Del Carmen" class="a6">
					<option value = "Kilantaao" class="a6">
					<option value = "Kilomaon" class="a6">
					<option value = "Mabca" class="a6">
					<option value = "Minadongjol" class="a6">
					<option value = "Nato" class="a6">
					<option value = "Patitinan" class="a6">
					<option value = "San Antonio" class="a6">
					<option value = "San Isidro" class="a6">
					<option value = "San Roque" class="a6">
					<option value = "Santo Niño" class="a6">
					<option value = "Sibaguan" class="a6">
					<option value = "Tinorongan" class="a6">
					<option value = "Turague" class="a6">
						<!-- End of Sagnay Barangays -->
						<!-- Start of San Jose Barangays -->
					<option value = "Adiangao" class="a7">
					<option value = "Bagacay" class="a7">
					<option value = "Bahay" class="a7">
					<option value = "Boclod" class="a7">
					<option value = "Calalahan" class="a7">
					<option value = "Calawit" class="a7">
					<option value = "Camagong" class="a7">
					<option value = "Catalotoan" class="a7">
					<option value = "Danlog" class="a7">
					<option value = "Del Carmen" class="a7">
					<option value = "Dolo" class="a7">
					<option value = "Kinalansan" class="a7">
					<option value = "Mampirao" class="a7">
					<option value = "Manzana" class="a7">
					<option value = "Minoro" class="a7">
					<option value = "Palale" class="a7">
					<option value = "Ponglon" class="a7">
					<option value = "Pugay" class="a7">
					<option value = "Sabang" class="a7">
					<option value = "Salogon" class="a7">
					<option value = "San Antonio" class="a7">
					<option value = "San Juan" class="a7">
					<option value = "San Vicente" class="a7">
					<option value = "Santa Cruz" class="a7">
					<option value = "Soledad" class="a7">
					<option value = "Tagas" class="a7">
					<option value = "Tambangan" class="a7">
					<option value = "Telegrafo" class="a7">
					<option value = "Tominawog" class="a7">
						<!-- End of San Jose Barangays -->
						<!-- Start of Siruma Barangays -->
					<option value = "Bagong Sirang" class="a8">
					<option value = "Bahao" class="a8">
					<option value = "Boboan" class="a8">
					<option value = "Butawanan" class="a8">
					<option value = "Cabugao" class="a8">
					<option value = "Fundado" class="a8">
					<option value = "Homestead" class="a8">
					<option value = "La Purisima" class="a8">
					<option value = "Mabuhay" class="a8">
					<option value = "Malaconini" class="a8">
					<option value = "Matandang Siruma" class="a8">
					<option value = "Nalayahan" class="a8">
					<option value = "Pamintan-Bantilan" class="a8">
					<option value = "Pinitan" class="a8">
					<option value = "Poblacion" class="a8">
					<option value = "Salvacion" class="a8">
					<option value = "San Andres" class="a8">
					<option value = "San Ramon" class="a8">
					<option value = "Sulpa" class="a8">
					<option value = "Tandoc" class="a8">
					<option value = "Tongo-Bantigue" class="a8">
					<option value = "Vito" class="a8">
						<!-- End of Siruma Barangays -->
						<!-- Start of Tigaon Barangays -->
					<option value = "Abo" class="a9">
					<option value = "Cabalinadan" class="a9">
					<option value = "Caraycayon" class="a9">
					<option value = "Casuna" class="a9">
					<option value = "Consocep" class="a9">
					<option value = "Coyaoyao" class="a9">
					<option value = "Gaao" class="a9">
					<option value = "Gingaroy" class="a9">
					<option value = "Gubat" class="a9">
					<option value = "Huyonhuyon" class="a9">
					<option value = "Libod" class="a9">
					<option value = "Mabalodbalod" class="a9">
					<option value = "May-Anao" class="a9">
					<option value = "Panagan" class="a9">
					<option value = "Poblacion" class="a9">
					<option value = "Salvacion" class="a9">
					<option value = "San Antonio" class="a9">
					<option value = "San Francisco" class="a9">
					<option value = "San Miguel" class="a9">
					<option value = "San Rafael" class="a9">
					<option value = "Talojongon" class="a9">
					<option value = "Tinawagan" class="a9">
					<option value = "Vinagre" class="a9">
						<!-- End of Tigaon Barangays -->
						<!-- Start of Tinambac Barangays -->
					<option value = "Agay-Ayan" class="a10">
					<option value = "Antipolo" class="a10">
					<option value = "Bagacay" class="a10">
					<option value = "Banga" class="a10">
					<option value = "Bani" class="a10">
					<option value = "Bataan" class="a10">
					<option value = "Binalay" class="a10">
					<option value = "Bolaobalite" class="a10">
					<option value = "Buenavista" class="a10">
					<option value = "Buyo" class="a10">
					<option value = "Cagliliog" class="a10">
					<option value = "Caloco" class="a10">
					<option value = "Camagong" class="a10">
					<option value = "Canayonan" class="a10">
					<option value = "Cawaynan" class="a10">
					<option value = "Daligan" class="a10">
					<option value = "Filarca" class="a10">
					<option value = "La Medalla" class="a10">
					<option value = "La Purisima" class="a10">
					<option value = "Lupi" class="a10">
					<option value = "Magsaysay" class="a10">
					<option value = "Magtang" class="a10">
					<option value = "Mananao" class="a10">
					<option value = "New Caaluan" class="a10">
					<option value = "Olag Grande" class="a10">
					<option value = "Olag Pequeño" class="a10">
					<option value = "Old Caaluan" class="a10">
					<option value = "Pag-asa" class="a10">
					<option value = "Pantat" class="a10">
					<option value = "Sagrada" class="a10">
					<option value = "Salvacion" class="a10">
					<option value = "Salvacion Poblacion" class="a10">
					<option value = "San Antonio" class="a10">
					<option value = "San Isidro" class="a10">
					<option value = "San Jose" class="a10">
					<option value = "San Pascual" class="a10">
					<option value = "San Ramon" class="a10">
					<option value = "San Roque" class="a10">
					<option value = "San Vicente" class="a10">
					<option value = "Santa Cruz" class="a10">
					<option value = "Sogod" class="a10">
					<option value = "Tambang" class="a10">
					<option value = "Tierra Nevada" class="a10">
					<option value = "Union" class="a10">
						<!-- End of Tinambac Barangays -->
				</datalist>
				<label for = "add">Street Address </label><span class = "error">* <?php echo $addErr;?></span>
				<input placeholder="ex. San Isidro Street" type = "text" name = "add" class = "field" id = "st" value = ""> 
				
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
					$add = $town.", ".$brgy.", ".$add;
					$insert = "INSERT INTO `orders`
								(`id`, `username`, `productname`, `order_quantity`, `unit`, `price_as_of_order`, `market`, `address`, `contact`, `date_time`, `state`)
								VALUES ('$n', '$_SESSION[usern]', '$prod', '$ordr', '$unit', '$pric', '$mark', '$add', '$contact', '$date', 0)";
					$conn -> query($insert);

				}
				//Notify user

				$p = mysqli_fetch_array($conn -> query("SELECT COUNT(*) 
														FROM `notifications`"))[0]+1;
				$title = "Your order with ID#".$n." has been confirmed";
				$msg = "Your order with ID#".$n." has been confirmed, we will keep in touch with you by continuously updating you reagarding its status. You may receive an email or SMS regarding its status. Thank you!";
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