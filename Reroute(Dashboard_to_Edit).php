<?php

	//Connect to SQL database

	session_start();

	//Redirect to Sign Up page if not logged in

	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server,$usname,$pass,$dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn->connect_error);
	}

	$_SESSION["visit_user"] = "";
	$_SESSION["market"] = "";
	$_SESSION["product"] = "";
	$_SESSION["buy_arr"] = array();

	//If logged in but tries to access edit page even though not a market admin
	
	$on = mysqli_fetch_array($conn -> query("SELECT COUNT(*)
												FROM `credentials`
												WHERE `username` = '$_SESSION[usern]' AND `user_type` = 1"))[0];

	if($on > 0){
		header("Location: Edit.php");		
	}
	else{
		?>
		<script type = text/javascript>
			alert('You do not have market admin priviliges.');
			location.href = 'Research.php';
		</script>
		<?php
	}
?>