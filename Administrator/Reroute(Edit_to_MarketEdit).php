<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();

	//Redirect to Sign Up page if not logged in

	if($_SESSION["admin"] == ''){
		header("Location: Login.php");
	}

	//If logged in but tries to access market page even though a market link has not been clicked
	
	if($_GET["market"] == ''){
		header("Location: Research.php");
	}
	else{
		$_SESSION["market"] = $_GET["market"];

		session_start();

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
		header("Location: MarketEdit.php");
	}
?>