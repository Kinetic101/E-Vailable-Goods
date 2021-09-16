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
		unset($_SESSION["usern"]);
		unset($_SESSION["market"]);
		unset($_SESSION["visit_user"]);
		unset($_SESSION["product"]);
	}

	

	//JS function to trim unnecessary characters from input

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
		    if(!preg_match("/^[a-zA-Z-' ]*$/",$uname)){
      			$unameErr = "Only letters and white space allowed";
      			$error = True;
    		}
		}
		if(empty($_POST["email"])){
		    $emailErr = "Email is required";
		    $error = True;
		} 
		else{ 
		   	$email = test_input($_POST["email"]);
		    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
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
		}
		if(empty($_POST["fname"])){
			$fnameErr = "First Name is required";
		    $error = True;
		} 
		else{
		    $fname = test_input($_POST["fname"]);
		}
		if(empty($_POST["lname"])){
		    $lnameErr = "Last Name is required";
		    $error = True;
		} 
		else{
		    $lname = test_input($_POST["lname"]);
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
				$user = $admin != "" ? True : False;
				$insert = "INSERT INTO `credentials` 
							(`username`, `email`, `pass`, `fname`, `lname`, `online`, `user_type`, `pic`) 
							VALUES ('$uname', '$email', '$pword', '$fname', '$lname', 1, '$user', './ProfilePix/X5ksjijoa2i39aind239.jpg')";
				$_SESSION["usern"] = $uname;
				$_SESSION["prof_pic"] = "./ProfilePix/X5ksjijoa2i39aind239.jpg";
				$_SESSION["market"] = "";
				$_SESSION["visit_user"] = "";
				$_SESSION["buy_arr"] = array();
				if($conn -> query($insert) == False){
					die("Error: ".$insert."<br>".$conn -> error);
				}
				header("Location: Profile.php");
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
	<link rel = "stylesheet" href = "SignUpCSS.css"> 
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
			Username: <br> <input type = "text" name = "uname" class = "field" value = "<?php echo $uname?>"> <span class = "error">* <?php echo $unameErr;?></span> <br>
			E-Mail: <br>  <input type = "text" name = "email" class = "field" value = "<?php echo $email?>"> <span class = "error">* <?php echo $emailErr;?></span> <br>
			Password: <br> <input type = "password" name = "pword" class = "field"> <span class = "error">* <?php echo $pwordErr;?></span> <br>
			First Name: <br> <input type = "text" name = "fname" class = "field" value = "<?php echo $fname?>"> <span class = "error">* <?php echo $fnameErr;?></span> <br>
			Last Name: <br> <input type = "text" name = "lname" class = "field" value = "<?php echo $lname?>"> <span class = "error">* <?php echo $lnameErr;?></span> <br>
			<input type = "radio" id = "admin" name = "user_type"  value = "admin" <?php if($admin != ""){echo "checked";}?>> Market Admin <span class = "error"> * <?php echo $adminErr; ?> </span> <br>
			<input type = "radio" id = "cust" name = "user_type" value = "cust" <?php if($cust != ""){echo "checked";}?>> Customer <span class = "error"> * <?php echo $custErr; ?> </span> <br>
			<br>
			<input type = "submit" value = "Sign Up" class = "button">
		</form>
	</div>
</body>
</html>