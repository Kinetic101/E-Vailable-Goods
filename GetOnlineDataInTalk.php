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
	$select = "SELECT `username`, `fname`, `lname`,`pic` FROM `credentials` WHERE `online` = 1 AND `username` != '$_SESSION[usern]'";
	$res = $conn -> query($select);
	?>
	<h1 class = "now">Active Now</h1>
	<?php
	while($row = $res -> fetch_assoc()) {
		?>
		<a href = "Talk.php?user=<?php echo $row["username"]; ?>">
			<h5><img src="<?php echo $row["pic"]; ?>" id="chatur"/>
			<?php echo $row["fname"]." ".$row["lname"]; ?> </h5>
		</a>
		<?php
	}
?>