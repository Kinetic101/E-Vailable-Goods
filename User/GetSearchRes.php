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
	if(isset($_GET["filter"])){
		$filter = $_GET["filter"];
		$selecto = "SELECT `username`, `fname`, `lname`, `pic`
					FROM `credentials`
					WHERE `username` != '$_SESSION[usern]'
					ORDER BY `username` ASC";
		$res = $conn -> query($selecto);
		while($row = $res -> fetch_assoc()){
			$name = $row["fname"]." ".$row["lname"];
			if(stripos($name, $filter) !== FALSE){
			?>
				<a href = "Visit_User.php?user=<?php echo $row["username"]; ?>">
					<div class = "chaturc"><img src="<?php echo $row["pic"]; ?>" id="chatur" style="width:40px;height:40px"></div>
					<h5>
					<?php echo $name; ?>
					</h5>
				</a>
			<?php
			}
		}
	}
?>