<?php

	//Connect to SQL database

	session_start();

	//Redirect to Sign Up page if not logged in

	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	//If logged in but tries to access a user page even though a user has not been clicked

	$_SESSION["market"] = "";
	$_SESSION["product"] = "";
	$_SESSION["visit_user"] = "";
	if($_GET["user"] == ''){
		header("Location: Research.php");
	}
	else{
		
		$_SESSION["visit_user"] = $_GET["user"];

		$server = "localhost";
		$usname = "root";
		$pass = "";
		$dbname = "user";
		$conn = new mysqli($server,$usname,$pass,$dbname);
		if($conn -> connect_error){
			die("Connection Failed: ".$conn->connect_error);
		}
		header("Location: Visit_User.php");
	}
?>