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

	use PHPMailer\PHPMailer\PHPMailer;

	if(isset($_POST["email"]) && isset($_POST["fname"]) && isset($_POST["lname"])){
		$name = $_POST["fname"]." ".$_POST["lname"];
		$email = $_POST["email"];
		$otp = strval(rand(0, 999999));
		for($i = strlen($otp); $i < 6; $i++){
			$otp = "0".$otp;
		}
		$body = "Hi ".$name.", your email verification OTP is: ".$otp;
		$subject = "E-Vailable Goods SignUp - Email OTP verification";

		$EVGemail = "evailablegoods@gmail.com";
		$EVGpassw = "masterCats_6996";

		require_once "PHPMailer/PHPMailer.php";
		require_once "PHPMailer/SMTP.php";
		require_once "PHPMailer/Exception.php";

		$mail = new PHPMailer();

		//SMTP config
		$mail -> isSMTP();
		$mail -> Host = "ssl://smtp.gmail.com";
		$mail -> SMTPAuth = true;
		$mail -> Username = $EVGemail;
		$mail -> Password = $EVGpassw;
		$mail -> Port = 465;
		$mail -> SMTPSecure = "ssl";
		$mail -> Mailer = "smtp";

		//Email config
		$mail -> isHTML(true);
		$mail -> setFrom($EVGemail, "E-Vailable Goods");
		$mail -> addAddress($email, $name);
		$mail -> Subject = $subject;
		$mail -> Body =  $body;

		if($mail -> send()){
			$status = "success";
			$response = "OTP sent";
			$_SESSION["otp"] = $otp;
			$_SESSION["cnt_re"] = 0;
		}
		else{
			$status = "error";
			$response = "Server error: <br>".$mail -> ErrorInfo;
		}
	}
?>