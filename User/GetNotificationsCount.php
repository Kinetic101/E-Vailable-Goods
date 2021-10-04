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
						FROM `notifications` 
						WHERE `username` = '$_SESSION[usern]' AND `unread` = 1";
	if(mysqli_fetch_array($conn -> query($select_count))[0] > 0){
		?>
		<span class="fa-stack fa-1x">
			<i class="fa fa-bell fa-stack-1x" id="bellalarm"></i>
			<i class="fa fa-circle fa-stack-1x fa-xs" title="You currently have notifications" style="color: red; font-size: 80%; left: 20%; top: -20%;"></i>
		</span>
		<?php
	}
	else{
		?>
		<i class="fas fa-bell" id="bell" title="You currently do not have notifications"></i>
		<?php
	}
?>