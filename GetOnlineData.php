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
	$select = "SELECT `username`, `fname`, `lname` FROM `credentials` WHERE `online` = 1 AND `username` != '$_SESSION[usern]'";
	$res = $conn -> query($select);
	echo "<h1 class = now>"."Active Now"."</h1>";
	while($row = $res -> fetch_assoc()) {
		echo "<a href = Reroute(Dashboard_to_VisitUser).php?user=$row[username]>"."<h5>".$row["fname"]." ".$row["lname"]."</h5>"."</a>";
	}
?>