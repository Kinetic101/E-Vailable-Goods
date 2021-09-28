<?php

	//Connect to SQL database
	session_start();

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "user";
	$conn = new mysqli($server,$usname,$pass,$dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn->connect_error);
	}
	
	if(isset($_SESSION["usern"])){
		$update = "UPDATE `credentials` SET online = 0 WHERE `username` = '$_SESSION[usern]'";
		$conn -> query($update);
		session_unset();
	}

	//Function to trim unnecessary characters from input

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	//Input user credentials 

	$emailErr = $pwordErr = "";
	$email = $pword = "";
	$error = $input = False;
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$input = True;
		if(empty($_POST["email"])){
		    $emailErr = "Email is required";
		    $error = True;
		} 
		else{
		    $email = test_input($_POST["email"]);
		}
		if(empty($_POST["pword"])){
		    $pwordErr = "Password is required";
		    $error = True;
		} 
		else{
		    $pword = test_input($_POST["pword"]);
		}
		if($input){
			if(!$error){
				$check = "SELECT * FROM `credentials` WHERE `email` = '$email'";
				$res = $conn->query($check);
				if($res -> num_rows > 0){
					$find = "SELECT `pass` FROM `credentials` WHERE `email` = '$email'";
				  	$query = $conn -> query($find);
				  	$fin = "";
				  	while($res = $query -> fetch_assoc()){
				  		$fin = $res["pass"];
				  	}
					if($fin == md5($pword)){
						$find = "SELECT `username`, `pic`, `user_type` FROM `credentials` WHERE `email` = '$email'";
						$query = $conn -> query($find);
					  	$uname = "";
					  	$ppic = "";
					  	$ust = 0;
					  	while($res = $query -> fetch_assoc()){
					  		$uname = $res["username"];
					  		$ppic = $res["pic"];
					  		$ust = $res["user_type"];
					  	}
					  	$_SESSION["prof_pic"] = $ppic;
						$_SESSION["usern"] = $uname;
						$_SESSION["market"] = "";
						$_SESSION["visit_user"] = "";
						$_SESSION["notif_id"] = "";
						$_SESSION["buy_arr"] = array();
						$_SESSION["author"] = 0;
						$_SESSION["order_id"] = 0;
						$update = "UPDATE `credentials` SET `online` = 1 WHERE `email` = '$email'";
				  		$conn -> query($update);
				  		if($ust == 0){
							header("Location: Research.php");
						}
						else{
							header("Location: Edit.php");
						}
					}
					else{
						$pwordErr = "Incorrect Password!";
					}
				}
				else{
					$emailErr = "Email does not exist!";
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel = "stylesheet" href = "LoginCSS.css"> 
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="LoginJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<title>Log In</title>
</head>
<body>
	<header>
		<nav>
		<ul class = "links">
			<li><a href="Login.php" id = "press">Login</a></li>
			<li><a href="Signup.php" class = "inactive">Signup</a></li>
		</ul>
		</nav>
	</header>

	<div class = "header">
		<h1 id = "evg">E-Vailable <br> Goods</h1>
	</div>
	
	<div class = "login">
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			E-Mail: <br> <input type = "email" name = "email" class = "field" value = "<?php echo $email;?>" id="email" maxlength="25"> <span class = "error">* <?php echo $emailErr;?></span> <br>
			Password: <br> <input type = "password" name = "pword" class = "field" id="pword" maxlength="25"> <span class = "error">* <?php echo $pwordErr;?></span> <br>
			<br>
			<input type = "submit" value = "Log In" class = "button" id="submit">
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