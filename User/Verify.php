<!DOCTYPE html>
<?php

	//Connect to SQL database
	session_start();
	if($_SESSION["uname"] == ''){
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
	
	if(isset($_SESSION["usern"])){
		$update = "UPDATE `credentials` SET online = 0 WHERE `username` = '$_SESSION[usern]'";
		$conn -> query($update);
		session_unset();
	}
	$_SESSION["cnt_re"]++;
?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Verify</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="VerifyCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="LoadingJS.js"></script>
</head>
<body>

	<div id = "verify">
		<h4>Please input the 6-digit OTP we have sent you through the email you provided. It will expire in 5 mins and once 5 mins have passed, you will automatically be redirected back to the Sign Up page. Moreover, you only have 5 attempts to input the corrrect OTP or else, you will also automatically be redirected back to the Sign Up page. Moreover, please DO NOT refresh the page, doing so will redirect you to the sign up page. Please check your spam folder.</h4>
		<form action = "">
			OTP: <input type = "number" name = "otp" id="otp">
			<br>
			<button type="button" id="submit">Check OTP</button>
		</form>
	</div>

	<div id="loading">
		<div class="content">
			<div class="load-wrapp">
				<div class="load">
					<p>Loading</p>
					<div class="line"></div>
					<div class="line"></div>
					<div class="line"></div>
				</div>
			</div>
		</div>
		<!--Credits to @Manoz from CodePen for the loading screen-->
	</div>

</body>
</html>
<script type="text/javascript" src="VerifyJS.js"></script>
<?php
	if($_SESSION["cnt_re"] > 1){
		?>
		<script type="text/javascript">
			swal({
				title: "Page Reloaded", 
				text: "You reloaded the page, you will now be redirected back to the Sign Up page!", 
				icon: "warning"
			})
			.then(function(){
				location.href = 'SignUp.php';
			});
		</script>
		<?php
	}
?>