<!DOCTYPE html>
<?php
	session_start();
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
	if(isset($_POST["yes"])){
		$update = "UPDATE `notifications`
					SET `unread` = 0
					WHERE `username` = '$_SESSION[usern]'";
		$conn -> query($update);
	}
?>