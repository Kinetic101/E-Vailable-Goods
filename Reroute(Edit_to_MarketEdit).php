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
	<title>Authorization</title>
	<link rel="stylesheet" type="text/css" href="AuthorizationCSS.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="AuthorizationJS.js"></script>
</head>
<body>

	<a href="Edit.php"><i class="fa fa-arrow-left"></i></a>
	<h4>For security purposes, you are to input the required security code to access the edit page for <?php echo $_SESSION["market"]; ?></h4>
	<form action="">
		<input name="password" type="password" id="pw">
		<button type="button" id="submit">Submit</button>
	</form>
	<div id="message"></div>

</body>
</html>