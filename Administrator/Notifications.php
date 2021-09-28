<?php
	//Connect to SQL database
	session_start();

	if($_SESSION["admin"] == ""){
		header("Location: Login.php");
	}

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

	//Function to trim unnecessary characters from input

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$_SESSION["user"] = "";

	$unameErr = $titleErr = $msgErr = "";
	$uname = $title = $msg = "";
	$error = $input = False;
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$input = True;
		if(empty($_POST["uname"])){
		    $unameErr = "Username is required";
		    $error = True;
		} 
		else{
		    $uname = test_input($_POST["uname"]);
		}
		if(empty($_POST["title"])){
		    $titleErr = "Title is required";
		    $error = True;
		} 
		else{
		    $title = test_input($_POST["title"]);
		}
		if(empty($_POST["msg"])){
		    $msgErr = "Message is required";
		    $error = True;
		} 
		else{
		    $msg = test_input($_POST["msg"]);
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
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel = "stylesheet" href = "NotificationsCSS.css"> 
	<link rel="stylesheet" type="text/css" href="NavBarCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="NavBarJS.js"></script>
	<script type="text/javascript" src="NotificationsJS.js"></script>
	<title>Admin Dashboard</title>
</head>
<body>

	<header>
		<nav class="navbar navbar-expand-custom navbar-mainbg">
	        <a class="navbar-brand navbar-logo" href="#">E-Vailable Goods - Administration Website</a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	        <i class="fas fa-bars text-white"></i>
	        </button>
	        <div class="collapse navbar-collapse" id="navbarSupportedContent">
	            <ul class="navbar-nav ml-auto">
	                <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
	                <li class="nav-item">
	                    <a class="nav-link" href="Dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Users.php"><i class="far fa-address-book"></i>Users</a>
	                </li>
	                <li class="nav-item active">
	                    <a class="nav-link" href="Notifications.php"><i class="fas fa-bell"></i>Notifications</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Orders.php"><i class="fas fa-clipboard-list"></i>Orders</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Messages.php"><i class="fas fa-inbox"></i>Messages</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Edit.php"><i class="fas fa-edit"></i>Edit</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Logout.php"><i class="fas fa-sign-out-alt"></i>Log Out</a>
	                </li>
	            </ul>
	        </div>
	    </nav>
	</header>

	<div id="searchuser">
		<h3 style="padding-left: 10px">Search User</h3>
		<i class="fas fa-search" id="inpicon"></i>
		<input type="text" placeholder="Search for user here." id="inp">
		<hr>
		<div class="userss">
		<?php
			$select = "SELECT `username`, `fname`, `lname`
						FROM `credentials`";
			$res = $conn_user -> query($select);
			while($row = $res -> fetch_assoc()){
				echo "<h5>".$row["username"].": ".$row["fname"]." ".$row["lname"]."<hr></h5>";
			}
		?>
		</div>
	</div>

	<div id="addnotif">
		<h3 style="padding-left: .1%">Send Notification to User</h3>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
			Username: <br> <input type="text" name="uname" value="<?php echo $uname; ?>"> <span class = "error">* <?php echo $unameErr;?></span>
			<br>
			Title: <br> <textarea type="text" id="title" name="title" rows="4" cols="50" value="<?php echo $title; ?>"></textarea> <span class = "error">* <?php echo $titleErr;?></span>
			<br>
			Message: <br> <textarea type="text" id="msg" name="msg" rows="8" cols="50" value="<?php echo $msg; ?>"></textarea> <span class = "error">* <?php echo $msgErr;?></span>
			<br>
			<input type="submit" name="submit" value="Notify User">
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
<?php
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if($titleErr == ""){
			?>
			<script type="text/javascript">
				$("#title").val('<?php echo $title; ?>');
			</script>
			<?php
		}
		if($msgErr == ""){
			?>
			<script type="text/javascript">
				$("#msg").val('<?php echo $msg; ?>');
			</script>
			<?php
		}

		if($input){
			if(!$error){
				$check = "SELECT * FROM `credentials` WHERE `username` = '$uname'";
				$res = $conn_user -> query($check);
				if($res -> num_rows > 0){
					$p = mysqli_fetch_array($conn_user -> query("SELECT COUNT(*) 
														FROM `notifications`"))[0]+1;
					$insert = "INSERT INTO `notifications`
								(`id`, `username`, `notif_title`, `notif_msg`, `unread`)
								VALUES ('$p', '$uname', '$title', '$msg', 1)";
					$conn_user -> query($insert);
					?>
					<script type="text/javascript">
						var uname = '<?php echo $uname; ?>';
						swal({
							icon: "success",
							title: `User ${uname} has been notified`
						})
						.then(function(){
							location.href = "Notifications.php";
						})
					</script>
					<?php
				}
				else{
					$unameErr = "Username does not exist!";
					?>
					<script type="text/javascript">
						swal({
							icon: "error",
							title: "Username is Non-Existent",
							message: "The username you entered is non-existent, please input an existing username."
						})
					</script>
					<?php
				}
			}
		}
	}
?>