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

	<div id="wait">
		<div class="wait">
			<i class="fa fa-spinner fa-pulse"></i>
			<h5>Loading...</h5>
			<h5>Please Wait</h5>
		</div>
	</div>

	<div id = "verify">
		<h1>Verification</h1>
		<h4>Please input the 6-digit OTP we have sent you through the email you provided.<br><br>It will expire in 5 mins and once 5 mins have passed, 
			you will automatically be redirected back to the Sign Up page. Moreover, you only have <span id = "warning">5 attempts</span> 
			to input the corrrect OTP or else, you will also automatically be redirected back to the Sign Up page. Moreover, please 
			<span id = "warning">DO NOT refresh the page</span>, doing so will redirect 
			you to the sign up page. <span style="color:#241F19; font-weight: 1000">Lastly, please check your spam folder.</span>
		<div class = "ent">
		<form action = "">
			<input type = "number" name = "otp" id="otp" maxlength="6">
			<br>
			<button type="button" id="submit">Check OTP</button>
		</form>
		</div>
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