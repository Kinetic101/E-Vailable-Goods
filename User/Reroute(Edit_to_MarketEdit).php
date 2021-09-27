<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();

	//Redirect to Sign Up page if not logged in

	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$_SESSION["visit_user"] = "";

	//If logged in but tries to access market page even though a market link has not been clicked
	
	if($_GET["market"] == ''){
		header("Location: Research.php");
	}
	else{
		$_SESSION["market"] = $_GET["market"];

		$server = "localhost";
		$usname = "root";
		$pass = "";
		$dbname = "user";
		$conn = new mysqli($server,$usname,$pass,$dbname);
		if($conn -> connect_error){
			die("Connection Failed: ".$conn->connect_error);
		}
	}
?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Authorization for <?php echo $_SESSION["market"]; ?> Edit</title>
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
</body>
</html>
<?php
	if($_GET["market"] == "market1"){
		$select = "SELECT `m1`
					FROM `credentials`
					WHERE `username` = '$_SESSION[usern]'";
		$ok = 0;
		$res = $conn -> query($select);
		while($row = $res -> fetch_assoc()){
			$ok = $row["m1"];
		}
		if($ok == 1){
			header("Location: MarketEdit.php");
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
	else if($_GET["market"] == "market2"){
		$select = "SELECT `m2`
					FROM `credentials`
					WHERE `username` = '$_SESSION[usern]'";
		$ok = 0;
		$res = $conn -> query($select);
		while($row = $res -> fetch_assoc()){
			$ok = $row["m2"];
		}
		if($ok == 1){
			header("Location: MarketEdit.php");
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
	else if($_GET["market"] == "market3"){
		$select = "SELECT `m3`
					FROM `credentials`
					WHERE `username` = '$_SESSION[usern]'";
		$ok = 0;
		$res = $conn -> query($select);
		while($row = $res -> fetch_assoc()){
			$ok = $row["m3"];
		}
		if($ok == 1){
			header("Location: MarketEdit.php");
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
	else if($_GET["market"] == "market4"){
		$select = "SELECT `m4`
					FROM `credentials`
					WHERE `username` = '$_SESSION[usern]'";
		$ok = 0;
		$res = $conn -> query($select);
		while($row = $res -> fetch_assoc()){
			$ok = $row["m4"];
		}
		if($ok == 1){
			header("Location: MarketEdit.php");
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
	else if($_GET["market"] == "market5"){
		$select = "SELECT `m5`
					FROM `credentials`
					WHERE `username` = '$_SESSION[usern]'";
		$ok = 0;
		$res = $conn -> query($select);
		while($row = $res -> fetch_assoc()){
			$ok = $row["m5"];
		}
		if($ok == 1){
			header("Location: MarketEdit.php");
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
	else if($_GET["market"] == "market6"){
		$select = "SELECT `m6`
					FROM `credentials`
					WHERE `username` = '$_SESSION[usern]'";
		$ok = 0;
		$res = $conn -> query($select);
		while($row = $res -> fetch_assoc()){
			$ok = $row["m6"];
		}
		if($ok == 1){
			header("Location: MarketEdit.php");
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
?>