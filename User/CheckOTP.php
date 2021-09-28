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
	if(isset($_POST["otp"])){
		if($_POST["otp"] == $_SESSION["otp"]){
			$uname = $_SESSION["uname"];
			$email = $_SESSION["email"];
			$fname = $_SESSION["fname"];
			$lname = $_SESSION["lname"];
			$pword = $_SESSION["pword"];
			$user = $_SESSION["user_type"];
			$_SESSION["cnt_re"] = 0;
			$insert = "INSERT INTO `credentials` 
									(`username`, `email`, `pass`, `fname`, `lname`, `online`, `user_type`, `pic`, `m1`, `m2`, `m3`, `m4`, `m5`, `m6`) 
									VALUES ('$uname', '$email', '$pword', '$fname', '$lname', 1, '$user', './ProfilePix/X5ksjijoa2i39aind239.jpg', 0, 0, 0, 0, 0, 0)";
			$conn -> query($insert);
			session_unset();
			$_SESSION["usern"] = $uname;
			$_SESSION["prof_pic"] = "./ProfilePix/X5ksjijoa2i39aind239.jpg";
			$_SESSION["market"] = "";
			$_SESSION["visit_user"] = "";
			$_SESSION["buy_arr"] = array();
			$_SESSION["notif_id"] = "";
			$_SESSION["author"] = 0;
			$_SESSION["order_id"] = 0;
			echo "success";
		}
		else{
			echo "error";
		}
	}
?>