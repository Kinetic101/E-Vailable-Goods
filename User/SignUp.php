<!DOCTYPE html>
<?php

	//Connect to SQL database
	session_start();

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

	//Function to trim unnecessary characters from input

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$unameErr = $emailErr = $pwordErr = $fnameErr = $lnameErr = $adminErr = $custErr = "";
	$uname = $email = $pword = $fname = $lname = $admin = $cust = "";
	$error = $input = False ;
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$input = True;
		if(empty($_POST["uname"])) {
		    $unameErr = "Username is required";
		    $error = True;
		} 
		else{
		    $uname = test_input($_POST["uname"]);
		    if(strlen($pword) < 5 && strlen($uname) > 16){
		    	$unameErr = "Nice try but try again";
      			$error = True;
		    }
		    else if(!preg_match('/^[a-zA-Z0-9]{5,}$/', $uname)){
      			$unameErr = "Invalid username format";
      			$error = True;
    		}
		}
		if(empty($_POST["email"])){
		    $emailErr = "Email is required";
		    $error = True;
		} 
		else{ 
		   	$email = test_input($_POST["email"]);
		   	if(strlen($email) > 45){
		    	$emailErr = "Nice try but try again";
      			$error = True;
		    }
		    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      			$emailErr = "Invalid email format";
      			$error = True;
    		}
		}
		if(empty($_POST["pword"])) {
		    $pwordErr = "Password is required";
		    $error = True;
		} 
		else{
			$pword = test_input($_POST["pword"]);
			if(strlen($pword) < 8 && strlen($pword) > 25){
		    	$pwordErr = "Nice try but try again";
      			$error = True;
		    }
		    else{
		    	$pword = md5(test_input($_POST["pword"]));
		    }
		}
		if(empty($_POST["fname"])){
			$fnameErr = "First Name is required";
		    $error = True;
		} 
		else{
		    $fname = test_input($_POST["fname"]);
		    if(strlen($fname) > 16){
		    	$fnameErr = "Nice try but try again";
      			$error = True;
		    }
		}
		if(empty($_POST["lname"])){
		    $lnameErr = "Last Name is required";
		    $error = True;
		} 
		else{
		    $lname = test_input($_POST["lname"]);
		    if(strlen($lname) > 16){
		    	$lnameErr = "Nice try but try again";
      			$error = True;
		    }
		}
		if(!isset($_POST["user_type"])){
			$adminErr = $custErr = "Please select one";
			$error = True;
		}
		else{
			if($_POST["user_type"] == "admin"){
				$admin = "checked";
			}
			else{
				$cust = "checked";
			}
		}
		if($input){
			$check = "SELECT * FROM `credentials` WHERE `username` = '$uname'";
			$res = $conn -> query($check);
			if($res -> num_rows > 0 && $unameErr == ""){
				$error = True;
				$unameErr = "Username is already being used";
			}
			$check = "SELECT * FROM `credentials` WHERE `email` = '$email'";
			$res = $conn -> query($check);
			if($res -> num_rows > 0 && $emailErr == ""){
				$error = True;
				$emailErr = "Email is already being used";
			}
			if(!$error){
				if($admin != ""){
					$user = 1;
				}
				else{
					$user = 0;
				}
				$_SESSION["uname"] = $uname;
				$_SESSION["email"] = $email;
				$_SESSION["fname"] = $fname;
				$_SESSION["lname"] = $lname;
				$_SESSION["pword"] = $pword;
				$_SESSION["user_type"] = $user;
				$_SESSION["otp"] = "";
				header("Location: SendOTP.php");
			}
		}
	}
?>

<html>
<head>

	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="SignUpJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<link rel = "stylesheet" href = "SignUpCSS.css"> 
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<title>Sign Up</title>

</head>

<body>
<header>
	<nav>
	<ul class = "links">
		<li><a href="Login.php" id = "inactive">Login</a></li>
		<li><a href="Signup.php" id = "press">Signup</a></li>
	</ul>
	</nav>
</header>

	<div class = "header">
		<h1 id = "evg">E-Vailable <br> Goods</h1>
	</div>

	<div class = "login"> 
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			Username: <span style="font-size: 10px;">(must consist of alphanumeric characters)</span> <br> <input type = "text" placeholder="Must be between 5 and 16 characters" name = "uname" class = "field" value = "<?php echo $uname?>" id="uname" maxlength="16"> <span class = "error" id="unameE">* <?php echo $unameErr;?></span> <br>
			E-Mail: <br>  <input type = "email" placeholder="Must not exceed 40 characters" name = "email" class = "field" value = "<?php echo $email?>"id="email" maxlength="45"> <span class = "error">* <?php echo $emailErr;?></span> <br>
			Password: <br> <input type = "password" placeholder="Must be between 8 and 16 characters" name = "pword" class = "field" id="pword" maxlength="25"> <span class = "error">* <?php echo $pwordErr;?></span> <br>
			First Name: <br> <input type = "text" placeholder="Must not exceed 16 characters" name = "fname" class = "field" value = "<?php echo $fname?>" id="fname" maxlength="16"> <span class = "error">* <?php echo $fnameErr;?></span> <br>
			Last Name: <br> <input type = "text" placeholder="Must not exceed 16 characters" name = "lname" class = "field" value = "<?php echo $lname?>" id="lname" maxlength="16"> <span class = "error">* <?php echo $lnameErr;?></span> <br>
			<input type = "radio" id = "admin" name = "user_type"  value = "admin" <?php if($admin != ""){echo "checked";}?>> Market Admin <span class = "error"> * <?php echo $adminErr; ?> </span> <br>
			<input type = "radio" id = "cust" name = "user_type" value = "cust" <?php if($cust != ""){echo "checked";}?>> Customer <span class = "error"> * <?php echo $custErr; ?> </span> 
			<br>
			<br>
			<input type = "submit" value = "Sign Up" class = "button" id="submit">
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

