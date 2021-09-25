<?php

	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$_SESSION["market"] = "";
	$_SESSION["visit_user"] = "";

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}
	$select_count = "SELECT COUNT(*) 
						FROM `notifications` 
						WHERE `username` = '$_SESSION[usern]' AND `unread` = 1";
	if(mysqli_fetch_array($conn -> query($select_count))[0] > 0){
		?>
		<i class="fas fa-bell" id="press"></i>
		<?php
	}
	else{
		?>
		<i class="fas fa-bell" id="press"></i>
		<?php	
	}
?>