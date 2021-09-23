<?php
	//Connect to SQL database

	session_start();
	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}
	else if($_SESSION["market"] == ""){
		header("Location: Research.php");
	}

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

	$pass = $_GET["password"];
	if($_SESSION["market"] == "market1"){
		if($pass == "KS3JCNMK4732MC4542DF"){
			$_SESSION["author"] = 1;
			?>
			<p>Authorized</p>
			<?php
		}
		else{
			?>
			<p>Incorrect security code</p>
			<?php
		}
	}
	else if($_SESSION["market"] == "market2"){
		if($pass == "J3IVNI3NCIW9ELM6KWS9"){
			$_SESSION["author"] = 1;
			?>
			<p>Authorized</p>
			<?php
		}
		else{
			?>
			<p>Incorrect security code</p>
			<?php
		}
	}
	else if($_SESSION["market"] == "market3"){
		if($pass == "0E3MC8EN39CNR49DMC9D"){
			$_SESSION["author"] = 1;
			?>
			<p>Authorized</p>
			<?php
		}
		else{
			?>
			<p>Incorrect security code</p>
			<?php
		}
	}
	else if($_SESSION["market"] == "market4"){
		if($pass == "NCLW3J48DN573UNC92L5"){
			$_SESSION["author"] = 1;
			?>
			<p>Authorized</p>
			<?php
		}
		else{
			?>
			<p>Incorrect security code</p>
			<?php
		}
	}
	else if($_SESSION["market"] == "market5"){
		if($pass == "MFH39SM493MT85MV8930"){
			$_SESSION["author"] = 1;
			?>
			<p>Authorized</p>
			<?php
		}
		else{
			?>
			<p>Incorrect security code</p>
			<?php
		}
	}
	else if($_SESSION["market"] == "market6"){
		if($pass == "E94MS94M583N4493K5G3"){
			$_SESSION["author"] = 1;
			?>
			<p>Authorized</p>
			<?php
		}
		else{
			?>
			<p>Incorrect security code</p>
			<?php
		}
	}
?>