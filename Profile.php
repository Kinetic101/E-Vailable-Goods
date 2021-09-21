<?php

	//Connect to SQL database

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

	$_SESSION["market"] = "";
	$_SESSION["product"] = "";
	
	//Function to trim unnecessary characters from input

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	//Update password int `credentials` table

	$opwErr = $npwErr = $rnpwErr = "";
	$opw = $npw = $rnpw = "";
	$error = $input = False;
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){


		//Check if errors are present in the input fields 

		$input = True;
		if(empty($_POST["opw"])) {
		    $opwErr = "This field is required";
		    $error = True;
		  } 
		  else{
		    $opw = test_input($_POST["opw"]);
		  }
		  if(empty($_POST["npw"])){
		    $npwErr = "This field is required";
		    $error = True;
		  } 
		  else{
		    $npw = test_input($_POST["npw"]);
		  }
		  if(empty($_POST["rnpw"])) {
		    $rnpwErr = "This field is required";
		    $error = True;
		  } 
		  else{
		    $rnpw = test_input($_POST["rnpw"]);
		  }

		  //Update

		  if($input){
			  if(!$error){
			  	$find = "SELECT `pass` FROM `credentials` WHERE `username` = '$_SESSION[usern]'";
			  	$query = $conn->query($find);
			  	$fin = "";
			  	while($res = $query->fetch_assoc()){
			  		$fin = $res["pass"];
			  	}
			  	if($fin == $opw){
				  	if($npw == $rnpw){
				  		$update = "UPDATE `credentials` SET pass = '$npw' WHERE `username` = '$_SESSION[usern]'";
				  		if($conn->query($update) == True){
				  			?>
				  			<script type='text/javascript'> 
				  				alert("Password successfully changed"); 
				  				location.href = "Profile.php";
				  			</script>
				  			<?php
				  		}
				  	}
				  	else{
				  		$rnpwErr = $npwErr = "New Passwords do not match";
				  	}
				}
				else{
					$opwErr = "Incorrect Old Password!";
				}
			}
			else{
				$rnpwErr = $npwErr = $opwErr = "Invalid Details";
			}
		}
	}

	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["up"]) && !isset($FILES["upload"])){
		$updir = "./ProfilePix/";
		$upfile = $updir.basename($_FILES["upload"]["name"]);
		$lol = explode('.', $_FILES["upload"]["name"]);
		$ext = strtolower(end($lol));
		$acc = array("jpg", "jpg", "png");
		if(in_array($ext, $acc)){
			if($_FILES["upload"]["size"] > 4000000){
				if(move_uploaded_file($_FILES["upload"]["tmp_name"], $upfile)){
					rename($upfile, $updir.$_SESSION["usern"].".".$ext);
					$upfile = $updir.$_SESSION["usern"].".".$ext;
					$update = "UPDATE `credentials` SET `pic` = '$upfile' WHERE `username` = '$_SESSION[usern]'";
					$conn -> query($update);
					$_SESSION["prof_pic"] = $upfile;
				}
			}
			else{
				?>
				<script type="text/javascript"> 
					alert('Maximum file size exceeded!'); 
				</script>
				<?php
			}
		}
		else{
			?>
			<script type="text/javascript"> 
				alert('Invalid file format!'); 
			</script>
			<?php
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
	<link rel = "stylesheet" href = "ProfileCSS.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="ProfileJS.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<title>Profile</title>
</head>
<body>
	<header>
		<nav>
			<ul class="links">
				<li><a href="Research.php">Buy</a></li>
				<li><a href="Talk.php">Talk</a></li>
				<li><a href="Edit.php">Edit</a></li>
				<li><a href="Suggest.php">Suggest</a></li>
				<li><a href="About.php">About</a></li>
			</ul>
		</nav>
		<ul class="icons">
			<li><a href="Cart.php"><i class="fas fa-shopping-cart" id="cart"></i></a></li>
			<li><a href="Notifications.php" id="notifsss"><i class="fas fa-bell" id="bell"></i></a></li>
		</ul>
		<a href = "Research.php" class = "evg">E-Vailable Goods</a>
		<ul>
		<li class = "dropdown"><a href = "Profile.php" class="pic">
			<div class="prof"><img src = "<?php echo $_SESSION["prof_pic"]?>" alt = "Avatar" class = "dp">
			</div>
		</a>
		<div class="dlinks">
      			<a href="Profile.php" id = "press">Profile</a>
      			<a href="#">Help & Support</a>
      			<a href="Logout.php">Logout</a>
    	</div>
    	</li>
		</ul>

	</header>

	<div class = "info">
		<div class="mprof">
			<a id = "magic1">
				<img src = "<?php echo $_SESSION["prof_pic"]?>" alt = "Avatar" class = "mdp">
			</a>
		</div>
		<h4 class = "cred">
			Username: <?php echo $_SESSION["usern"];?>
			<br>
			<?php
				$select = "SELECT `email`,`fname`,`lname` FROM `credentials` WHERE `username` = '$_SESSION[usern]'";
				$res = $conn->query($select);
				while($row = $res->fetch_assoc()) {
					echo 
					"E-Mail: ".$row["email"].
					"<br>".
					"First Name: ".$row["fname"].
					"<br>".
					"Last Name: ".$row["lname"];
				}
			?>
		</h4>
	</div>

	<div id = "upload_pic" style = "display: none">
		<h5>Accepted file formats are: png, jpg, jpeg</h5>
		<h5>Maximum file size is 4 MB</h5>
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype = "multipart/form-data">
			<input type = "file" name = "upload">
			<input type = "submit" name = "up" value = "Upload">
		</form>
		<button id = "magic2">
			<h6>Cancel</h6>
		</button>
	</div>

	<div class = "changep">
		<h3 class = "passer">Change your password</h3>
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type = "text" name = "opw" placeholder = "Old Password"> <span class = "error">* <?php echo $opwErr;?></span> 
			<br>
			<input type = "text" name = "npw" placeholder = "New Password"> <span class = "error">* <?php echo $npwErr;?></span> 
			<br> 
			<input type = "text" name = "rnpw" placeholder = "Re-enter New Password"> <span class = "error">* <?php echo $rnpwErr;?></span>
			<br>
			<input type = "submit" value = "Change Password" class = "button" name = "submit">
		</form>
	</div>
	<div class = "logout">
		<a href="Logout.php" class="lolo">Logout</a>
	</div>
</body>
</html>