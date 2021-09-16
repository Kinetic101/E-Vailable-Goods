<?php

	//Connect to SQL database

	session_start();

	if($_SESSION["usern"] == '' || !isset($_GET["us"])){
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

	$us = $_GET["us"];
	$select = "SELECT * 
				FROM `messages`
				WHERE (`from_user` = '$_SESSION[usern]' AND `to_user` = '$us') OR (`to_user` = '$_SESSION[usern]' AND `from_user` = '$us')
				ORDER BY `time` ASC";
	$check = "SELECT `online`
				FROM `credentials`
				WHERE `username` = '$_SESSION[visit_user]'";
	$res = $conn -> query($check);
	$ol = 0;
	while($row = $res -> fetch_assoc()){
		$ol = $row["online"];
	}
	/* START: nakafix dapat position neto*/
	echo "<div class = name>".$_SESSION["visit_user"]."<br>"; 
	if($ol){
		echo "<span class = ol>Online</span>";
	}
	else{
		echo "<span class = notol>Not Online</span>";
	}
	echo "</div>";
	/* END */
	$res = $conn -> query($select);
	while($row = $res -> fetch_assoc()){
		if($row["from_user"] == $_SESSION["usern"]){
			echo "<span class = from>".$row["message"]."</span><br>";
		}
		else{
			echo "<span class = to>".$row["message"]."</span><br>";
		}
	}
?>