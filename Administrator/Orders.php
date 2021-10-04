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
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel = "stylesheet" href = "OrdersCSS.css"> 
	<link rel="stylesheet" type="text/css" href="NavBarCSS.css">
	<link rel="stylesheet" type="text/css" href="LoadingCSS.css">
	<script type="text/javascript" src="LoadingJS.js"></script>
	<script type="text/javascript" src="NavBarJS.js"></script>
	<script type="text/javascript" src="OrdersJS.js"></script>
	<title>Admin - Orders</title>
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
	                <li class="nav-item">
	                    <a class="nav-link" href="Notifications.php"><i class="fas fa-bell"></i>Notifications</a>
	                </li>
	                <li class="nav-item active">
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
	<input type="text" placeholder="Search here. You can search for any of the categories below but you cannot join two or more categories to search (e.g. searching for user name and order id at the same time)." id="inp">

	<div id="orders">
		<table>
			<tr>
				<th>Order ID</th>
				<th>User Name</th>
				<th>Product(s)</th>
				<th>From Market(s)</th>
				<th>Total Price</th>
				<th>Address</th>
				<th>Contact</th>
				<th>Date & Time</th>
				<th>Order State</th>
			</tr>
			<?php
			$select = "SELECT DISTINCT `id`, `username`, `address`, `contact`, `date_time`, `state`
						FROM `orders`
						ORDER BY `id` DESC";
			$res = $conn_user -> query($select);
			$i = 0;
			while($row = $res -> fetch_assoc()){
				$id = "id".$i++;
				?>
				<div class="order_dets">
					<tr>
						<td><a href="OrderDetails.php?id=<?php echo $row["id"]; ?>"><?php echo "ID#".$row["id"]; ?></a></td>
						<td><?php echo $row["username"]; ?></td>
						<?php
						$n = mysqli_fetch_array($conn_user -> query("SELECT COUNT(DISTINCT(`productname`))
																			FROM `orders`
																			WHERE `id` = '$row[id]'"))[0];
						$selecto = "SELECT DISTINCT(`productname`)
									FROM `orders`
									WHERE `id` = '$row[id]'";
						$reso = $conn_user -> query($selecto);
						$sum = "";
						$pop = 0;
						while($rowo = $reso -> fetch_assoc()){
							$sum .= $rowo["productname"];
							if($pop < $n - 1){
								$sum .= ", ";
							}
							$pop++;
						}
						?>
						<td><?php echo $sum; ?></td>
						<?php
						$n = mysqli_fetch_array($conn_user -> query("SELECT COUNT(DISTINCT(`market`))
																			FROM `orders`
																			WHERE `id` = '$row[id]'"))[0];
						$selecto = "SELECT DISTINCT(`market`)
									FROM `orders`
									WHERE `id` = '$row[id]'";
						$reso = $conn_user -> query($selecto);
						$sum = "";
						$pop = 0;
						while($rowo = $reso -> fetch_assoc()){
							$sum .= $rowo["market"];
							if($pop < $n - 1){
								$sum .= ", ";
							}
							$pop++;
						}
						?>
						<td><?php echo $sum; ?></td>
						<?php
						$selecto = "SELECT `order_quantity`, `price_as_of_order`
									FROM `orders`
									WHERE `id` = '$row[id]'";
						$reso = $conn_user -> query($selecto);
						$sum = 0;
						while($rowo = $reso -> fetch_assoc()){
							$sum += $rowo["order_quantity"]*$rowo["price_as_of_order"];
						}
						?>
						<td>Php <?php echo $sum; ?></td>
						<td><?php echo $row["address"]; ?></td>
						<td><?php echo $row["contact"]; ?></td>
						<td><?php echo $row["date_time"]; ?></td>
						<td class="sw">
							<label class="switch">
								<input type="checkbox" <?php if($row["state"] == 1) echo "checked"; ?> <?php if($row["state"] == 1) echo "disabled"; ?>  id = "<?php echo $id; ?>"
									onclick="update_order('<?php echo $row["username"]; ?>', '<?php echo $id; ?>', '<?php echo $row["id"]?>');">
								<span class="slider round"></span>
							</label>
						</td>
					</tr>
				</tr>
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