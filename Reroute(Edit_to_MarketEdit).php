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

		header("Location: MarketEdit.php");
	}
?>