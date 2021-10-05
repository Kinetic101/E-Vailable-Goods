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

	$_SESSION["user"] = "";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/f463b44b8d.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel = "stylesheet" href = "DashboardCSS.css"> 
	<link rel="stylesheet" type="text/css" href="NavBarCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="DashboardJS.js"></script>
	<script type="text/javascript" src="NavBarJS.js"></script>
	<title>Admin - Dashboard</title>
</head>
<body>

	<div id="wait">
		<div class="wait">
			<i class="fa fa-spinner fa-pulse"></i>
			<h5>Loading...</h5>
			<h5>Please Wait</h5>
		</div>
	</div>

	<header>
		<nav class="navbar navbar-expand-custom navbar-mainbg">
	        <a class="navbar-brand navbar-logo" href="#">E-Vailable Goods - Administration Website</a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	        <i class="fas fa-bars text-white"></i>
	        </button>
	        <div class="collapse navbar-collapse" id="navbarSupportedContent">
	            <ul class="navbar-nav ml-auto">
	                <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
	                <li class="nav-item active">
	                    <a class="nav-link" href="Dashboard.php"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link" href="Users.php"><i class="far fa-address-book"></i>Users</a>
	                </li>
	                <li class="nav-item">
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
	<div class = "row1">
	<div class = "loginLogs">
	<h2>Login Logs</h2>
	<table>
		<tr>
			<th>IP Address</th>
			<th>Time</th>
		</tr>
		<tr>
			<td><!--Insert necessary code-->127.0.0.1</td>
			<td><!--Insert necessary code-->2021-08-31 21:14:35</td>
		</tr>
	</table>
	</div>
	<div class = "editLogs">
	<h2>Edit Logs</h2>
	<table>
		<tr>
			<th>Product Name</th>
			<th>Market</th>
			<th>Username</th>
			<th>Old Quantity</th>
			<th>New Quantity</th>
			<th>Unit</th>
			<th>Old Price</th>
			<th>New Price</th>
			<th>Time</th>
		</tr>
		<tr>
			<td><!--Insert necessary code-->Frosh</td>
			<td><!--Insert necessary code-->Market 1</td>
			<td><!--Insert necessary code-->Username</td>
			<td><!--Insert necessary code-->900</td>
			<td><!--Insert necessary code-->9</td>
			<td><!--Insert necessary code-->sachet(s)</td>
			<td><!--Insert necessary code-->Php2500</td>
			<td><!--Insert necessary code-->Php2499</td>
			<td><!--Insert necessary code-->2021-08-31 21:32:12</td>
		</tr>
	</table>
	</div>
	</div>
	<hr>
	<div class="row2">
		<h2>Suggestions</h2>
		<div id = "suggList">
			<div id="suggBox">
			<p><!--Insert necessary code-->Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
			</div>
		</div>
	</div>
	<!--Mga ilalagay sa page na to:
			*logs nung naglogin sa admin page
			*logs nung mga tigedit sa market, both user and admin
			*listahan ng suggestions
		Last feature na to
		Palagays na lang ng layout muna, yung logs table yung style tas yung suggestions simpleng listahan lang 
	-->

</body>
</html>