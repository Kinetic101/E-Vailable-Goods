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
		$id = $_POST["id"];
		$update = "UPDATE `orders`
					SET `state` = 1
					WHERE `id` = '$id' AND `username` = '$username'";
		$conn_user -> query($update);
		$title = "Your order with ID#".$id." has been accomplished";
		$msg = "Your order with ID#".$id." has been accomplished. Thank you for using our platform. You have also helped curb food oversupply! Thanks again!";
		$p = mysqli_fetch_array($conn_user -> query("SELECT COUNT(*) 
														FROM `notifications`"))[0]+1;
		$insert = "INSERT INTO `notifications`
					(`id`, `username`, `notif_title`, `notif_msg`, `unread`)
					VALUES ('$p', '$username', '$title', '$msg', 1)";
		$conn_user -> query($insert);
	}
?>	