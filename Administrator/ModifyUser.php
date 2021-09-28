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
		$title = $msg = "";
		if($market == '1'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m1` = 1
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 1 Awarded";
				$msg = "We have fully verified your identity, you now have editting access to Market 1";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m1` = 0
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 1 Revoked";
				$msg = "Due to security reasons, we have revoked your editting access to Market 1";
			}
		}
		else if($market == '2'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m2` = 1
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 2 Awarded";
				$msg = "We have fully verified your identity, you now have editting access to Market 2";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m2` = 0
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 2 Revoked";
				$msg = "Due to security reasons, we have revoked your editting access to Market 2";
			}
		}
		else if($market == '3'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m3` = 1
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 3 Awarded";
				$msg = "We have fully verified your identity, you now have editting access to Market 3";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m3` = 0
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 3 Revoked";
				$msg = "Due to security reasons, we have revoked your editting access to Market 3";
			}
		}
		else if($market == '4'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m4` = 1
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 4 Awarded";
				$msg = "We have fully verified your identity, you now have editting access to Market 4";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m4` = 0
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 4 Revoked";
				$msg = "Due to security reasons, we have revoked your editting access to Market 4";
			}
		}
		else if($market == '5'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m5` = 1
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 5 Awarded";
				$msg = "We have fully verified your identity, you now have editting access to Market 5";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m5` = 0
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 5 Revoked";
				$msg = "Due to security reasons, we have revoked your editting access to Market 5";
			}
		}
		else if($market == '6'){
			if($check == 0){
				$update = "UPDATE `credentials`
							SET `m6` = 1
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 6 Awarded";
				$msg = "We have fully verified your identity, you now have editting access to Market 6.";
			}
			else{
				$update = "UPDATE `credentials`
							SET `m6` = 0
							WHERE `username` = '$username'";
				$title = "Edit Access to Market 6 Revoked";
				$msg = "Due to security reasons, we have revoked your editting access to Market 6";
			}
		}
		$p = mysqli_fetch_array($conn_user -> query("SELECT COUNT(*) 
														FROM `notifications`"))[0]+1;
		$insert = "INSERT INTO `notifications`
					(`id`, `username`, `notif_title`, `notif_msg`, `unread`)
					VALUES ('$p', '$username', '$title', '$msg', 1)";
		$conn_user -> query($insert);
		$conn_user -> query($update);
	}

?>