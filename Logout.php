<!DOCTYPE html>

<?php

	//Connect to SQL database

	session_start();
	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server,$usname,$pass,$dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn->connect_error);
	}

	//Logout

	
	$update = "UPDATE `credentials` SET online = 0 WHERE `username` = '$_SESSION[usern]'";
	$conn -> query($update);
	unset($_SESSION["usern"]);
	unset($_SESSION["market"]);
	unset($_SESSION["visit_user"]);
	unset($_SESSION["product"]);
	unset($_SESSION["prof_pic"]);
	unset($_SESSION["buy_arr"]);
	unset($_SESSION["notif_id"]);
	unset($_SESSION["author"]);
	unset($_SESSION["order_id"]);
	session_destroy();
	header("Location: Login.php");
?>