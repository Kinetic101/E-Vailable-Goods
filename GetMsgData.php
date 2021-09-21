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

	if($_SESSION["visit_user"] != ""){
		$select = "SELECT * 
					FROM `messages`
					WHERE (`from_user` = '$_SESSION[usern]' AND `to_user` = '$_SESSION[visit_user]') OR (`to_user` = '$_SESSION[usern]' AND `from_user` = '$_SESSION[visit_user]')
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
		echo "<div id = name>".$_SESSION["visit_user"]."<br>"; 
		if($ol){
			echo "<span class = ol>Online</span>";
		}
		else{
			echo "<span class = notol>Not Online</span>";
		}
		echo "</div><div id = msgss>";
		/* END */
		$res = $conn -> query($select);
		while($row = $res -> fetch_assoc()){
			if($row["from_user"] == $_SESSION["usern"]){
				echo "<div class = from>".$row["message"]."</div><br><div class = br></div>";
			}
			else{
				echo "<div class = to>".$row["message"]."</div><br><div class = brto></div>";
			}
		}
		echo "</div>";
	}
	else{
		echo "Please select a chat.";
	}
?>