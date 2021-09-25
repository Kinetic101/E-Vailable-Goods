<!DOCTYPE html>
<?php

	//Connect to SQL database

	session_start();

	//Redirect to Sign Up page if not logged in

	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$_SESSION["visit_user"] = "";

	//If logged in but tries to access market page even though a market link has not been clicked
	
	if($_GET["market"] == ''){
		
		header("Location: Research.php");
	}
	else{
		$_SESSION["market"] = $_GET["market"];

		$server = "localhost";
		$usname = "root";
		$pass = "";
		$dbname = "user";
		$conn = new mysqli($server,$usname,$pass,$dbname);
		if($conn -> connect_error){
			die("Connection Failed: ".$conn->connect_error);
		}
	}
	if($_SESSION["market"] == "market1"){
		$_SESSION["cnt_re1"]++;
	}
	else if($_SESSION["market"] == "market2"){
		$_SESSION["cnt_re2"]++;
	}
	else if($_SESSION["market"] == "market3"){
		$_SESSION["cnt_re3"]++;
	}
	else if($_SESSION["market"] == "market4"){
		$_SESSION["cnt_re4"]++;
	}
	else if($_SESSION["market"] == "market5"){
		$_SESSION["cnt_re5"]++;
	}
	else if($_SESSION["market"] == "market6"){
		$_SESSION["cnt_re6"]++;
	}
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Authorization for <?php echo $_SESSION["market"]; ?> Edit</title>
	<link rel="stylesheet" type="text/css" href="AuthorizationCSS.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="AuthorizationJS.js"></script>
</head>
<body>

	<a href="Edit.php"><i class="fa fa-arrow-left"></i></a>
	<h4>For security purposes, you are to input the required security code to access the edit page for <?php echo $_SESSION["market"]; ?>. You only have 5 minutes and 3 attempts to do so. You will be logged out once you run out of attempts or the 5 minutes have passed. Reloading this page will redirect you back to the Edit Dashboard.</h4>
	<form action="">
		<input name="password" type="password" id="pw">
		<button type="button" id="submit">Submit</button>
	</form>
	<div id="message"></div>

</body>
</html>
<?php
	if(($_SESSION["market"] == "market1" && $_SESSION["cnt_re1"] > 1) || ($_SESSION["market"] == "market2" && $_SESSION["cnt_re2"] > 1) || ($_SESSION["market"] == "market3" && $_SESSION["cnt_re3"] > 1) || ($_SESSION["market"] == "market4" && $_SESSION["cnt_re4"] > 1) || ($_SESSION["market"] == "market5" && $_SESSION["cnt_re5"] > 1) || ($_SESSION["market"] == "market6" && $_SESSION["cnt_re6"] > 1)){
		?>
		<script type="text/javascript">
			swal({
				title: "Page Reloaded", 
				text: "You have reloaded the page; thus, you will be logged out", 
				icon: "error"
			})
			.then(function(){
				location.href = 'Logout.php';
			});
		</script>
		<?php
	}
?>