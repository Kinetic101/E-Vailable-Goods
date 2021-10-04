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
		  	if(strlen($_POST["opw"]) < 8 && strlen($_POST["opw"]) > 25){
		  		$opwErr = "Nice try but try again";
		  		$error = True;
		  	}
		  	else{
		    	$opw = test_input($_POST["opw"]);
		    }
		  }
		  if(empty($_POST["npw"])){
		    $npwErr = "This field is required";
		    $error = True;
		  } 
		  else{
		  	if(strlen($_POST["npw"]) < 8 && strlen($_POST["npw"]) > 25){
		  		$npwErr = "Nice try but try again";
		  		$error = True;
		  	}
		  	else{
		    	$npw = test_input($_POST["npw"]);
		    }
		  }
		  if(empty($_POST["rnpw"])) {
		    $rnpwErr = "This field is required";
		    $error = True;
		  } 
		  else{
		  	if(strlen($_POST["rnpw"]) < 8 && strlen($_POST["rnpw"]) > 25){
		  		$rnpwErr = "Nice try but try again";
		  		$error = True;
		  	}
		  	else{
		    	$rnpw = test_input($_POST["rnpw"]);
		    }
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
			  	if($fin == md5($opw)){
				  	if($npw != $rnpw){
				  		$rnpwErr = $npwErr = "New Passwords do not match";
				  	}
				}
				else{
					$opwErr = "Incorrect Old Password!";
				}
			}
			else if(($opwErr != "Nice try but try again" && $npwErr != "Nice try but try again" && $rnpwErr != "Nice try but try again") && $error){
				$rnpwErr = $npwErr = $opwErr = "Invalid Details";
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
	<link rel = "stylesheet" href = "ProfileCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<link rel="stylesheet" type="text/css" href="SearchCSS.css">
	<script src="https://kit.fontawesome.com/f463b44b8d.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="ProfileJS.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="SearchJS.js"></script>
	<title>Profile</title>
</head>
<body>
	<header>
		<nav>
			<ul class="links">
				<li><a href="Research.php">Buy</a></li>
				<li id="here"><a href="Talk.php">Talk</a></li>
				<li><a href="Edit.php">Edit</a></li>
				<li><a href="Suggest.php">Suggest</a></li>
				<li><a href="About.php">About</a></li>
				<li class="search-bar">
					<input type="text" placeholder="Search for others" class="inp">
					<i class="fas fa-search"></i>
					<div id="sres"></div>
				</li>
			</ul>
		</nav>
		<ul class="icons">
			<li><a href="Cart.php" title="Cart"><i class="fas fa-shopping-cart" id="cart"></i></a></li>
			<li><a href="Notifications.php" id="notifsss" title="Notifications"><i class="fas fa-bell" id="bell"></i></a></li>
			<li><a href="Orders.php" title="Orders"><i class="fas fa-receipt"></i></a></li>
		</ul>
		<a href = "Research.php" class = "evg">E-Vailable Goods</a>
		<ul>
		<li class = "dropdown"><a href = "Profile.php" class="pic">
			<div class="prof"><img src = "<?php echo $_SESSION["prof_pic"]?>" alt = "Avatar" class = "dp">
			</div>
		</a>
		<div class="dlinks">
      			<a href="Profile.php" id = "press">Profile</a>
      			<a href="Help_and_Support.php">Help & Support</a>
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
			<span id="usern">Username: <?php echo $_SESSION["usern"]."</span>";?>
			<br>
			<?php
				$select = "SELECT `email`,`fname`,`lname`,`user_type` FROM `credentials` WHERE `username` = '$_SESSION[usern]'";
				$res = $conn->query($select);
				while($row = $res->fetch_assoc()) {
					echo 
					"<span id =name>".$row["fname"]." ".
					$row["lname"]."</span>".
					"<br>".
					"<span id=email>".$row["email"]."</span>".
					"<br>"."<span id =email>"."User Type: "."</span>";
					if($row["user_type"] == 0){
						echo "<span id =email>"."Customer"."</span>";
					}
					else{
						echo "<span id =email>"."Market Administrator"."</span>";
					}
				}
			?>
		</h4>
	</div>

	<div id = "upload_pic" style = "display: none">
		<h5 class="cons">Accepted file formats are: png, jpg, jpeg<br>Maximum file size is 4 MB</h5>
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype = "multipart/form-data" class="mform">
			<input type = "file" name = "upload" class="fload">
			<input type = "submit" name = "up" value = "Upload" class="uload">
		</form>
		<button id = "magic2">
			<h6>Cancel</h6>
		</button>
	</div>

	<div class = "changep">
		<h3 class = "passer">Change your password</h3>
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<input type = "text" name = "opw" placeholder = "Old Password" id="opassw" maxlength="25"> <span class = "error">* <?php echo $opwErr;?></span> 
			<br>
			<input type = "text" name = "npw" placeholder = "New Password" id="npassw" maxlength="25"> <span class = "error">* <?php echo $npwErr;?></span> 
			<br> 
			<input type = "text" name = "rnpw" placeholder = "Re-enter New Password" id="rnpassw" maxlength="25"> <span class = "error">* <?php echo $rnpwErr;?></span>
			<br>
			<input type = "submit" value = "Change Password" class = "button" name = "submit" id="changepass">
		</form>
	</div>
	<div class = "logout">
		<a href="Logout.php" class="lolo">Logout</a>
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
<?php
	if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
		$find = "SELECT `pass` FROM `credentials` WHERE `username` = '$_SESSION[usern]'";
		$query = $conn->query($find);
		$fin = "";
		while($res = $query->fetch_assoc()){
			$fin = $res["pass"];
		}
		if($npw == $rnpw && $fin == $opw && $input && !$error){
			$npw = md5($npw);
			$update = "UPDATE `credentials` SET pass = '$npw' WHERE `username` = '$_SESSION[usern]'";
			if($conn->query($update) == True){
				?>
				<script type="text/javascript"> 
					swal({
						title: "Password Changed", 
						text: "You have successfully changed your password", 
						icon: "success"
					})
					.then(function(){
						location.href = "Profile.php";
					});
				</script>
				<?php
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
			if($_FILES["upload"]["size"] <= 4000000){
				if(move_uploaded_file($_FILES["upload"]["tmp_name"], $upfile)){
					rename($upfile, $updir.$_SESSION["usern"].".".$ext);
					$upfile = $updir.$_SESSION["usern"].".".$ext;
					$update = "UPDATE `credentials` SET `pic` = '$upfile' WHERE `username` = '$_SESSION[usern]'";
					$conn -> query($update);
					$_SESSION["prof_pic"] = $upfile;
					?>
					<script type="text/javascript"> 
						swal({
							title: "Profile Picture Updated", 
							text: "You have successfully changed your profile picture", 
							icon: "success"
						})
						.then(function(){
							location.href = "Profile.php";
						});
					</script>
					<?php
				}
			}
			else{
				?>
				<script type="text/javascript"> 
					swal({
						title: "Invalid", 
						text: "Maximum file size has exceeded 4MB", 
						icon: "error"
					});
				</script>
				<?php
			}
		}
		else{
			?>
			<script type="text/javascript"> 
				swal({
						title: "Invalid", 
						text: "Invalid file format", 
						icon: "error"
					});
			</script>
			<?php
		}
	}
?>