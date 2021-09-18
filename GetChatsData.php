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
	$check = array();
	$select = "SELECT *
				FROM `messages`
				WHERE `from_user` = '$_SESSION[usern]' OR `to_user` = '$_SESSION[usern]' ORDER BY `time` DESC";
	$res = $conn -> query($select);
	while($row = $res -> fetch_assoc()){
		if($row["from_user"] == $_SESSION["usern"]){
			if(!array_key_exists($row["to_user"], $check)){
				echo "<a href = Talk.php?user=$row[to_user]>".$row["to_user"]."<br></a>";
			}
			$check[$row["to_user"]] = True;
		}
		else{
			if(!array_key_exists($row["from_user"], $check)){
				echo "<a href = Talk.php?user=$row[from_user]>".$row["from_user"]."<br></a>";
			}
			$check[$row["from_user"]] = True;
		}
	}
?>