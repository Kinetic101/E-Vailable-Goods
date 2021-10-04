<!DOCTYPE html>
<?php
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
	$_SESSION["author"] = 0;
?>
<html>
<head>
	<meta charset = "utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel = "stylesheet" href = "NotificationsCSS.css"> 
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<link rel="stylesheet" type="text/css" href="SearchCSS.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="AreThereNotifs.js"></script>
	<script type="text/javascript" src="GetNotificationsJS.js"></script>
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="SearchJS.js"></script>
	<script type="text/javascript" src="NotificationsJS.js"></script>
	<title>Notifications</title>

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
					<div id="sres">
						<?php
						$select = "SELECT `username`, `fname`, `lname`, `pic`
									FROM `credentials`
									WHERE `username` != '$_SESSION[usern]'
									ORDER BY `username` ASC";
						$res = $conn -> query($select);
						while($row = $res -> fetch_assoc()){
							?>
							<a href = "Reroute(Dashboard_to_VisitUser).php?user=<?php echo $row["username"]; ?>">
								<div class = "chaturc"><img src="<?php echo $row["pic"]; ?>" id="chatur" style="width:40px;height:40px"></div>
								<h5>
								<?php echo $row["fname"]." ".$row["lname"]; ?>
								</h5>
							</a>
							<?php
						}
						?>
					</div>
				</li>
			</ul>
		</nav>
		<ul class="icons">
			<li><a href="Cart.php" title="Cart"><i class="fas fa-shopping-cart" id="cart"></i></a></li>
			<li><a href="Notifications.php" title="Notifications" id="bello"><i class="fas fa-bell"></i></a></li>
			<li><a href="Orders.php" title="Orders"><i class="fas fa-receipt"></i></a></li>
		</ul>
		<a href = "Research.php" class = "evg">E-Vailable Goods</a>
		<ul>
			<li class = "dropdown">
				<a href = "Profile.php" class="pic">
					<div class="prof"><img src = "<?php echo $_SESSION["prof_pic"]?>" alt = "Avatar" class = "dp"></div>
				</a>
				<div class="dlinks">
		      		<a href="Profile.php">Profile</a>
		      		<a href="Help_and_Support.php">Help & Support</a>
		      		<a href="Logout.php">Logout</a>
		    	</div>
	    	</li>
		</ul>
	</header>

	<div id="notifs">
		<div class = "taas">
		<h3 class="notift">Your Notifications</h3>
		<button type="button" id = "mread">Mark all as read</button>
		</div>
		<div class = "notif_list">
		<?php
			$select = "SELECT *
						FROM `notifications`
						WHERE `username`  = '$_SESSION[usern]'
						ORDER BY `id` DESC";
			$res = $conn -> query($select);
			while($row = $res -> fetch_assoc()){
			?>
				
					<a href="Reroute(Notifications_to_NotifMessage).php?id=<?php echo $row["id"]; ?>">
						<div class="notif_box">
						<?php
						if($row["unread"] == 0){
						?>
							<h3 style="font-weight: 100;" id="notift"><?php echo $row["notif_title"]; ?></h3>
						<?php
						}
						else{
						?>
							<h3 style="font-weight: 1000;" id="notift"><?php echo $row["notif_title"]; ?></h3>
						<?php
						}
						?>
					</div>
					</a>
				<hr id="nhr">
			<?php
			}
		?>
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
