<?php
	//Connect to SQL database
	session_start();

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname_user = "user";
	$dbname_admin = "admin";
	$conn_user = new mysqli($server, $usname, $pass, $dbname_user);
	$conn_admin = new mysqli($server, $usname, $pass, $dbname_admin);
	if($conn_user -> connect_error){
		die("Connection Failed: ".$conn_user -> connect_error);
	}
	if($conn_admin -> connect_error){
		die("Connection Failed: ".$conn_admin -> connect_error);
	}

	if(isset($_SESSION["admin"])){
		session_unset();
	}

	//Function to trim unnecessary characters from input

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


	$pword = "";
	$uname = "";
	$error = $input = false;
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$input = True;
		if(empty($_POST["uname"])){
		    $error = True;
		} 
		else{
		    $uname = test_input($_POST["uname"]);
		}
		if(empty($_POST["pword"])){
		    $error = True;
		} 
		else{
		    $pword = test_input($_POST["pword"]);
		}
		if($input){
			if(!$error){
				$pass = "masterCats_6996";
				if(md5($pword) == md5($pass)){
					$_SESSION["admin"] = 1;
					header("Location: Dashboard.php");
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
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel = "stylesheet" href = "LoginCSS.css"> 
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="LoadingJS.js"></script>
	<title>Admin Login</title>
</head>
<body>

	<div id="login">
		<div class="screen">
			<div class="content">
				<form class="login_form" method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="login_field">
						<i class="login_icon fas fa-user"></i>
						<input type="text" name="uname" class="login_input" value="<?php echo $uname; ?>" placeholder="User Name"> 
					</div>
					<div class="login_field">
						<i class="login_icon fas fa-lock"></i>
						<input type="password" name="pword" class="login_input" placeholder="Password">
					</div>
					<button class="submit">
						<span class="button_text">Log In</span>
						<i class="button_icon fas fa-chevron-right"></i>
					</button>				
				</form>
			</div>
			<div class="screen_bg">
				<span class="screen_bg_sh s4"></span>
				<span class="screen_bg_sh s3"></span>		
				<span class="screen_bg_sh s2"></span>
				<span class="screen_bg_sh s1"></span>
			</div>		
		</div>
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