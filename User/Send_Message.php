<?php	
	session_start();

	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

	if(!empty($_POST["msg"])){	
		$date = date("Y-m-d H:i:s");
		$insert = "INSERT INTO `messages`
					(`from_user`, `to_user`, `message`, `time`, `unread`)
					VALUES('$_SESSION[usern]', '$_SESSION[visit_user]', '$_POST[msg]', '$date', 1)";
		$conn -> query($insert);
	}
?>