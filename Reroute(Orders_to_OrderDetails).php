<?php
	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server,$usname,$pass,$dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn->connect_error);
	}
	if($_GET["id"] == ""){
		header("Location: Orders.php");
	}
	else{
		$_SESSION["order_id"] = $_GET["id"];
		header("Location: OrderDetails.php");
	}
?>