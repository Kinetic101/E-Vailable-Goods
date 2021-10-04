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
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/f463b44b8d.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel = "stylesheet" href = "UsersCSS.css"> 
	<link rel="stylesheet" type="text/css" href="NavBarCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="UsersJS.js"></script>
	<script type="text/javascript" src="NavBarJS.js"></script>
	<title>Admin - Users</title>
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
	                <li class="nav-item active">
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

	<i class="fas fa-search" id="inpicon"></i>
	<input type="text" placeholder="Search here. You can search for any of the categories below but you cannot join two or more categories to search (e.g. searching for first and last name at the same time)." id="inp">
	
	<div id="user">
		<table>
			<tr>
				<th>User Name</th>
				<th>Email</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Online</th>
				<th>User Type</th>
				<th>Profile Picture</th>
				<th>Market 1</th>
				<th>Market 2</th>
				<th>Market 3</th>
				<th>Market 4</th>
				<th>Market 5</th>
				<th>Market 6</th>
				<th>Delete User</th>
			</tr>
			<?php
			$select = "SELECT *
						FROM `credentials`";
			$res = $conn_user -> query($select);
			$i = 0;
			while($row = $res -> fetch_assoc()){
				$id = "id".$i++;
				?>
				<div class="user_creds">
					<tr>
						<td><a href="Messages.php?user=<?php echo $row["username"]; ?>"><?php echo $row["username"]; ?></a></td>
						<td><?php echo $row["email"]; ?></td>
						<td><?php echo $row["fname"]; ?></td>
						<td><?php echo $row["lname"]; ?></td>
						<?php 
							if($row["online"] == 1){
							?>
								<td><span class="ol">Online</span></td>
							<?php
							}
							else{
							?>	
								<td><span class="notol">Not Online</span></td>
							<?php
							}
						?>
						<?php 
							if($row["user_type"] == 0){
							?>
								<td><span class="mark_cus">Customer</span></td>
							<?php
							}
							else{
							?>	
								<td><span class="mark_adm">Market Admin</span></td>
							<?php
							}
						?>
						<?php
							$pic = "";
							for($x = 13; $x < strlen($row["pic"]); $x++){
								$pic .= $row["pic"][$x];
							}
						?>
						<td><?php echo $pic; ?></td>
						<?php
							if($row["user_type"] == 1){
							?>
							<td class="sw">
								<label class="switch">
									<input type="checkbox" <?php if($row["m1"] == 1) echo "checked"; ?> id = "<?php echo $id."1"; ?>" onclick="update_market_access('<?php echo $row["username"]; ?>', '<?php echo $id; ?>', '1')">
									<span class="slider round"></span>
								</label>
							</td>
							<td class="sw">
								<label class="switch">
									<input type="checkbox" <?php if($row["m2"] == 1) echo "checked"; ?> id = "<?php echo $id."2"; ?>" onclick="update_market_access('<?php echo $row["username"]; ?>', '<?php echo $id; ?>', '2')">
									<span class="slider round"></span>
								</label>
							</td>
							<td class="sw">
								<label class="switch">
									<input type="checkbox" <?php if($row["m3"] == 1) echo "checked"; ?> id = "<?php echo $id."3"; ?>" onclick="update_market_access('<?php echo $row["username"]; ?>', '<?php echo $id; ?>', '3')">
									<span class="slider round"></span>
								</label>
							</td>
							<td class="sw">
								<label class="switch">
									<input type="checkbox" <?php if($row["m4"] == 1) echo "checked"; ?> id = "<?php echo $id."4"; ?>" onclick="update_market_access('<?php echo $row["username"]; ?>', '<?php echo $id; ?>', '4')">
									<span class="slider round"></span>
								</label>
							</td>
							<td class="sw">
								<label class="switch">
									<input type="checkbox" <?php if($row["m5"] == 1) echo "checked"; ?> id = "<?php echo $id."5"; ?>" onclick="update_market_access('<?php echo $row["username"]; ?>', '<?php echo $id; ?>', '5')"> 
									<span class="slider round"></span>
								</label>
							</td>
							<td class="sw">
								<label class="switch">
									<input type="checkbox" <?php if($row["m6"] == 1) echo "checked"; ?> id = "<?php echo $id."6"; ?>" onclick="update_market_access('<?php echo $row["username"]; ?>', '<?php echo $id; ?>', '6')">
									<span class="slider round"></span>
								</label>
							</td>
						<?php
						}
						else{
							?>
							<td class="sw">N/A</td>
							<td class="sw">N/A</td>
							<td class="sw">N/A</td>
							<td class="sw">N/A</td>
							<td class="sw">N/A</td>
							<td class="sw">N/A</td>
							<?php
						}
						?>
						<td class="delete"><i class="fas fa-trash" id="<?php echo $id; ?>" onclick="del_user('<?php echo $row["username"]; ?>', '<?php echo $id; ?>')"></i></td>
					</tr>
				</div>
				<?php
			}
			?>
		</table>
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