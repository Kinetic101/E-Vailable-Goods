<?php

	//Connect to SQL database

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

	$select_count = "SELECT COUNT(*) 
						FROM `messages` 
						WHERE `to_user` = '$_SESSION[usern]' AND `unread` = 1";
	if(mysqli_fetch_array($conn -> query($select_count))[0] > 0){
		?>
		<a href="Talk.php" id="talk" style = "color: red;" title="You currently have unread messages">Talk</a>
		<?php
	}
	else{
		?>
		<a href="Talk.php" id="talk" title="You currently do not have unread messages">Talk</a>
		<?php
	}
?>