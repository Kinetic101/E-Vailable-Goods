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

	if($_SESSION["user"] != ""){
		$select = "SELECT * 
					FROM `messages`
					WHERE (`from_user` = 'dev' AND `to_user` = '$_SESSION[user]') OR (`to_user` = 'dev' AND `from_user` = '$_SESSION[user]')
					ORDER BY `time` ASC";
		$check = "SELECT `fname`,`lname`,`pic`,`online`
					FROM `credentials`
					WHERE `username` = '$_SESSION[user]'";
		$res = $conn_user -> query($check);
		$fn = $ln = $url = $ol = "";
		while($row = $res -> fetch_assoc()){
			$fn = $row["fname"];
			$ln = $row["lname"];
			for($i = 1; $i < strlen($row["pic"]); $i++){
				$url .= $row["pic"][$i];
			}
			$ol = $row["online"];
		}
		?>
		<div id = "name"> 
			<div class="pprof"> 
				<img src="<?php echo "../User".$url; ?>" class="pdp" style="height:100%;width:100%">
			</div>
			<div class="emannim">
				<?php echo $fn." ".$ln; ?> 
			<br>
		<?php
		if($ol){
			?>
			<span class = "ol">Online</span>
			<?php
		}
		else{
			?>
			<span class = "notol">Not Online</span>
			<?php
		}
		?>
			</div>
		</div>
		<div id = "msgss">
		<?php
		$res = $conn_admin -> query($select);
		while($row = $res -> fetch_assoc()){
			if($row["from_user"] == 'dev'){
				?>
				<span class = "from"><?php echo $row["message"]; ?></span>
				<div class = "br"></div>
				<?php
			}
			else{
				?>
				<div class = "to"> <?php echo $row["message"]; ?> </div>
				<div class = "br"></div>
				<?php
			}
		}
		?>
		</div>
		<?php
		$update = "UPDATE `messages`
					SET `unread` = 0
					WHERE (`to_user` = 'dev' AND `from_user` = '$_SESSION[user]') OR (`to_user` = '$_SESSION[user]' AND `from_user` = 'dev')";
		$conn_admin -> query($update);
	}
	else{
		?>
		<div id="name">
			Please select a chat
			<br>
			<span>+-+-+-+-+-+</span>
		</div>
		<span>Please select a chat</span>
		
		<?php
	}
?>