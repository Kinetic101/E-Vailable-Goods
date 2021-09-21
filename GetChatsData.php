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
				$check_unr = mysqli_fetch_array($conn -> query("SELECT COUNT(*)
																FROM `messages` 
																WHERE `to_user` = '$_SESSION[usern]' AND `from_user` = '$row[to_user]' AND `unread` = 1"))[0];
				if($check_unr > 0){
					?>
					<a href = "Talk.php?user=<?php echo $row["to_user"]; ?>" style="font-weight: bold;"> <?php echo $row["to_user"];?> <br></a>
					<?php
				}
				else{
					?>
					<a href = "Talk.php?user=<?php echo $row["to_user"]; ?>"> <?php echo $row["to_user"];?> <br></a>
					<?php
				}
			}
			$check[$row["to_user"]] = True;
		}
		else{
			if(!array_key_exists($row["from_user"], $check)){
				$check_unr = mysqli_fetch_array($conn -> query("SELECT COUNT(*)
																FROM `messages` 
																WHERE `to_user` = '$_SESSION[usern]' AND `from_user` = '$row[from_user]' AND `unread` = 1"))[0];
				if($check_unr > 0){
					?>
					<a href = "Talk.php?user=<?php echo $row["from_user"]; ?>" style="font-weight: bold;"> <?php echo $row["from_user"];?><br></a>
					<?php
				}
				else{
					?>
					<a href = "Talk.php?user=<?php echo $row["from_user"]; ?>"> <?php echo $row["from_user"];?> <br></a>
					<?php
				}
				
			}
			$check[$row["from_user"]] = True;
		}
	}
?>