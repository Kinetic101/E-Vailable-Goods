<!DOCTYPE html>
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
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

	$_SESSION["market"] = "";
	$_SESSION["visit_user"] = "";
	$_SESSION["product"] = "";

	//Function to trim unnecessary characters from input

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


	//Update database in `suggestions` table

	$suggErr = "";
	$sugg = "";
	$error = $input = False;

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$input = True;
		if(empty($_POST["sugg"])){
		    $suggErr = "Suggestion is required";
		    $error = True;
		} 
		else{
		    $sugg = test_input($_POST["sugg"]);
		}
	}
?>

<html>
<head>

	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel = "stylesheet" href = "SuggestCSS.css"> 
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<link rel="stylesheet" type="text/css" href="SearchCSS.css">
	<script src="https://kit.fontawesome.com/f463b44b8d.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="SuggestJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="SearchJS.js"></script>
	<title>Suggest</title>

</head>
<body>
	<header>
		<nav>
			<ul class="links">
				<li><a href="Research.php">Buy</a></li>
				<li id="here"><a href="Talk.php">Talk</a></li>
				<li><a href="Edit.php">Edit</a></li>
				<li><a href="Suggest.php" id = "press">Suggest</a></li>
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
      			<a href="Profile.php">Profile</a>
      			<a href="Help_and_Support.php">Help & Support</a>
      			<a href="Logout.php">Logout</a>
    	</div>
    	</li>
		</ul>

	</header>

	<div class = "suggest">
		<h2 class = "pgag">
			We are currently improving the platform to give our users the top-notch user-friendly experience we want them to have since we, as regular
			users of the World Wide Web, also know the struggles of having to deal with sluggish internet and unresponsive websites. 
			<br>
			In turn, we would like
			to ask for your feedback and any suggestions that you may have in mind, these will be used in the betterment for us, the website developers, you, the users, and the website itself.
			<br>
			Thank you and let us make the world a better place for everyone!
		</h2>
		<div class = "box">
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<br> 
			<h4 class = "comm">Suggest here</h4>
			<textarea type = "text" name = "sugg" class = "field" placeholder="Write your comment.." id="suggest"></textarea><span class = "error">*</span> <br>
			<br>
			<button type = "submit" class = "button" id="post_sugg">Suggest</button>
		</form>
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
<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if($input){
			if(!$error){
				$insert = "INSERT INTO `suggestions` (`entry`) VALUES ('$sugg')";
				$conn -> query($insert);	
				?>
				<script type = "text/javascript">
					swal({
							title: "Success", 
							text: "Your suggestion has been recorded!", 
							icon: "success"
						})
						.then(function(){
							location.href = 'Suggest.php';
						});
				</script>
				<?php
			}
		}
	}
?>