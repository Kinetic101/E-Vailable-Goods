<?php
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
	$check = array();
	$select = "SELECT *
				FROM `messages`
				WHERE `from_user` = 'dev' OR `to_user` = 'dev' ORDER BY `time` DESC";
	$res = $conn_admin -> query($select);
	while($row = $res -> fetch_assoc()){
		if($row["from_user"] == 'dev'){
			if(!array_key_exists($row["to_user"], $check)){
				$check_unr = mysqli_fetch_array($conn_admin -> query("SELECT COUNT(*)
																FROM `messages` 
																WHERE `to_user` = 'dev' AND `from_user` = '$row[to_user]' AND `unread` = 1"))[0];
				$selecto = "SELECT `fname`,`lname`,`pic`
							FROM `credentials` 
							WHERE `username` = '$row[to_user]'";
				$ln = $fn = $url = "";
				$resu = $conn_user -> query($selecto);
				while($rowi = $resu -> fetch_assoc()){
					$fn = $rowi["fname"];
					$ln = $rowi["lname"];
					for($i = 1; $i < strlen($rowi["pic"]); $i++){
						$url .= $rowi["pic"][$i];
					}
				}
				if($check_unr > 0){
					?>
					<div class = "cmate">
					<?php
						if($_SESSION["user"] == $row["to_user"]){
						?>
						<a href = "#"> 
						<?php
						}
						else{
						?>
						<a href = "Messages.php?user=<?php echo $row["to_user"]; ?>"> 
						<?php
						}
					?>
						<div class = "chatpicc"><img src="<?php echo "../User".$url; ?>" class="chatpic" style="width:55px;height:55px"></div>
						<h4 style="font-weight: bold;"> 
							<?php echo $fn." ".$ln;?>  
						</h4>
					</a>
					</div>
					<?php
				}
				else{
					?>
					<div class = "cmate">
					<?php
						if($_SESSION["user"] == $row["to_user"]){
						?>
						<a href = "#"> 
						<?php
						}
						else{
						?>
						<a href = "Messages.php?user=<?php echo $row["to_user"]; ?>"> 
						<?php
						}
					?>
						<div class = "chatpicc"><img src="<?php echo "../User".$url; ?>" class="chatpic" style="width:55px;height:55px"></div>
						<h4 style="font-weight: normal;"> 
							<?php echo $fn." ".$ln;?>  
						</h4>
					</a>
					</div>					<?php
				}
			}
			$check[$row["to_user"]] = True;
		}
		else{
			if(!array_key_exists($row["from_user"], $check)){
				$check_unr = mysqli_fetch_array($conn_admin -> query("SELECT COUNT(*)
																FROM `messages` 
																WHERE `to_user` = 'dev' AND `from_user` = '$row[from_user]' AND `unread` = 1"))[0];
				$selecto = "SELECT `fname`,`lname`,`pic`
							FROM `credentials` 
							WHERE `username` = '$row[from_user]'";
				$ln = $fn = $url = "";
				$resu = $conn_user -> query($selecto);
				while($rowi = $resu -> fetch_assoc()){
					$fn = $rowi["fname"];
					$ln = $rowi["lname"];
					for($i = 1; $i < strlen($rowi["pic"]); $i++){
						$url .= $rowi["pic"][$i];
					}
				}
				if($check_unr > 0){
					?>
					<div class = "cmate">
					<?php
						if($_SESSION["user"] == $row["from_user"]){
						?>
						<a href = "#"> 
						<?php
						}
						else{
						?>
						<a href = "Messages.php?user=<?php echo $row["from_user"]; ?>"> 
						<?php
						}
					?>
						<div class = "chatpicc"><img src="<?php echo "../User".$url; ?>" class="chatpic" style="width:55px;height:55px"></div>
						<h4 style="font-weight: bold;"> 
							<?php echo $fn." ".$ln;?>  
						</h4>
					</a>
					</div>
					<?php
				}
				else{
					?>
					<div class = "cmate">
					<?php
						if($_SESSION["user"] == $row["from_user"]){
						?>
						<a href = "#"> 
						<?php
						}
						else{
						?>
						<a href = "Messages.php?user=<?php echo $row["from_user"]; ?>"> 
						<?php
						}
					?>
						<div class = "chatpicc"><img src="<?php echo "../User".$url; ?>" class="chatpic" style="width:55px;height:55px"></div>
						<h4 style="font-weight: normal;"> 
							<?php echo $fn." ".$ln;?>  
						</h4>
					</a>
					</div>
					<?php
				}
			}
			$check[$row["from_user"]] = True;
		}
	}
?>