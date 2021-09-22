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

	if($_SESSION["visit_user"] != ""){
		$select = "SELECT * 
					FROM `messages`
					WHERE (`from_user` = '$_SESSION[usern]' AND `to_user` = '$_SESSION[visit_user]') OR (`to_user` = '$_SESSION[usern]' AND `from_user` = '$_SESSION[visit_user]')
					ORDER BY `time` ASC";
		$check = "SELECT `online`
					FROM `credentials`
					WHERE `username` = '$_SESSION[visit_user]'";
		$res = $conn -> query($check);
		$ol = 0;
		while($row = $res -> fetch_assoc()){
			$ol = $row["online"];
		}
		$selecto = "SELECT `fname`,`lname`,`pic`
					FROM `credentials`
					WHERE `username` = '$_SESSION[visit_user]'";
		$resu = $conn -> query($selecto);
		$fn = $ln = $url = "";
		while($rowi = $resu -> fetch_assoc()){
			$fn = $rowi["fname"];
			$ln = $rowi["lname"];
			$url = $rowi["pic"];
		}
		?>
		<div id = "name"> 
			<div class="pprof"> 
				<img src="<?php echo $url; ?>" class="pdp"/ style="height:100%;width:100%">
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
		$res = $conn -> query($select);
		while($row = $res -> fetch_assoc()){
			if($row["from_user"] == $_SESSION["usern"]){
				?>
				<div class = "from"> <?php echo $row["message"]; ?> </div>
				<br>
				<div class = "br"></div>
				<?php
			}
			else{
				?>
				<div class = "to"> <?php echo $row["message"]; ?> </div>
				<br>
				<div class = "brto"></div>
				<?php
			}
		}
		echo "</div>";
		$update = "UPDATE `messages`
					SET `unread` = 0
					WHERE `to_user` = '$_SESSION[usern]' AND `from_user` = '$_SESSION[visit_user]'";
		$conn -> query($update);
	}
	else{
		?>
		<div id="name">
			Please select a chat
			<br>
			</div>
		
		<?php
	}
?>