<?php
	//Connect to SQL database
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

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$username = $_POST["uname"];
		$market = $_POST["market"];
		$check = $_POST["check"];
		$update = "";
		if($market == '1'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m1` = 1
							WHERE `username` = '$username'";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m1` = 0
							WHERE `username` = '$username'";
			}
		}
		else if($market == '2'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m2` = 1
							WHERE `username` = '$username'";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m2` = 0
							WHERE `username` = '$username'";
			}
		}
		else if($market == '3'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m3` = 1
							WHERE `username` = '$username'";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m3` = 0
							WHERE `username` = '$username'";
			}
		}
		else if($market == '4'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m4` = 1
							WHERE `username` = '$username'";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m4` = 0
							WHERE `username` = '$username'";
			}
		}
		else if($market == '5'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m5` = 1
							WHERE `username` = '$username'";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m5` = 0
							WHERE `username` = '$username'";
			}
		}
		else if($market == '6'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m6` = 1
							WHERE `username` = '$username'";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m6` = 0
							WHERE `username` = '$username'";
			}
		}
		$conn_user -> query($update);
	}

?>