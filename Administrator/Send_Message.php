<?php	
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

	if(!empty($_POST["msg"]) && $_SESSION["user"] != ""){	
		$date = date("Y-m-d H:i:s");
		$insert = "INSERT INTO `messages`
					(`from_user`, `to_user`, `message`, `time`, `unread`)
					VALUES('dev', '$_SESSION[user]', '$_POST[msg]', '$date', 1)";
		$conn_admin -> query($insert);
	}
?>