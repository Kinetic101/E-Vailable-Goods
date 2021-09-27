<?php

	//Connect to SQL database

	session_start();

	if($_SESSION["usern"] == ''){
		header("Location: SignUp.php");
	}

	$server = "localhost";
	$usname = "root";
	$pass = "";
	$dbname = "admin";
	$conn = new mysqli($server, $usname, $pass, $dbname);
	if($conn -> connect_error){
		die("Connection Failed: ".$conn -> connect_error);
	}

	$select = "SELECT * 
				FROM `messages`
				WHERE (`from_user` = '$_SESSION[usern]' AND `to_user` = 'dev') OR (`to_user` = '$_SESSION[usern]' AND `from_user` = 'dev')
				ORDER BY `time` ASC";
	?>
	<div id="name">
		<div class="emanim">
			Chat with the Devs
			<br>
			You can also reach us at <span style="color: red;">evailablegoods@gmail.com</span>
		</div>
	</div>
	<div id = "msgss">
	<?php
	$res = $conn -> query($select);
	while($row = $res -> fetch_assoc()){
		if($row["from_user"] == $_SESSION["usern"]){
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
?>