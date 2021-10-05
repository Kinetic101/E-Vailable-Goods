<?php
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
	$check = array();
	$select = "SELECT *
				FROM `messages`
				WHERE `from_user` = '$_SESSION[usern]' OR `to_user` = '$_SESSION[usern]' ORDER BY `time` DESC";
	$res = $conn -> query($select);
	$k = 0;
	while($row = $res -> fetch_assoc()){
		$k++;
		if($row["from_user"] == $_SESSION["usern"]){
			if(!array_key_exists($row["to_user"], $check)){
				$check_unr = mysqli_fetch_array($conn -> query("SELECT COUNT(*)
																FROM `messages` 
																WHERE `to_user` = '$_SESSION[usern]' AND `from_user` = '$row[to_user]' AND `unread` = 1"))[0];
				$selecto = "SELECT `fname`,`lname`,`pic`
							FROM `credentials` 
							WHERE `username` = '$row[to_user]'";
				$ln = $fn = $url = "";
				$resu = $conn -> query($selecto);
				while($rowi = $resu -> fetch_assoc()){
					$fn = $rowi["fname"];
					$ln = $rowi["lname"];
					$url = $rowi["pic"];
				}
				if($check_unr > 0){
					?>
					<div class = "cmate">
					<?php
						if($_SESSION["visit_user"] == $row["to_user"]){
						?>
						<a href = "#"> 
						<?php
						}
						else{
						?>
						<a href = "Talk.php?user=<?php echo $row["to_user"]; ?>"> 
						<?php
						}
					?>
						<div class = "chatpicc"><img src="<?php echo $url; ?>" class="chatpic" style="width:55px;height:55px"></div>
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
						if($_SESSION["visit_user"] == $row["to_user"]){
						?>
						<a href = "#"> 
						<?php
						}
						else{
						?>
						<a href = "Talk.php?user=<?php echo $row["to_user"]; ?>"> 
						<?php
						}
					?>
						<div class = "chatpicc"><img src="<?php echo $url; ?>" class="chatpic" style="width:55px;height:55px"></div>
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
				$check_unr = mysqli_fetch_array($conn -> query("SELECT COUNT(*)
																FROM `messages` 
																WHERE `to_user` = '$_SESSION[usern]' AND `from_user` = '$row[from_user]' AND `unread` = 1"))[0];
				$selecto = "SELECT `fname`,`lname`,`pic`
							FROM `credentials` 
							WHERE `username` = '$row[from_user]'";
				$ln = $fn = $url = "";
				$resu = $conn -> query($selecto);
				while($rowi = $resu -> fetch_assoc()){
					$fn = $rowi["fname"];
					$ln = $rowi["lname"];
					$url = $rowi["pic"];
				}
				if($check_unr > 0){
					?>
					<div class = "cmate">
					<?php
						if($_SESSION["visit_user"] == $row["from_user"]){
						?>
						<a href = "#"> 
						<?php
						}
						else{
						?>
						<a href = "Talk.php?user=<?php echo $row["from_user"]; ?>"> 
						<?php
						}
					?>
						<div class = "chatpicc"><img src="<?php echo $url; ?>" class="chatpic" style="width:55px;height:55px"></div>
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
						if($_SESSION["visit_user"] == $row["from_user"]){
						?>
						<a href = "#"> 
						<?php
						}
						else{
						?>
						<a href = "Talk.php?user=<?php echo $row["from_user"]; ?>"> 
						<?php
						}
					?>
						<div class = "chatpicc"><img src="<?php echo $url; ?>" class="chatpic" style="width:55px;height:55px"></div>
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
	if($k == 0){
		?>
		<div class = "cmate">
			<h4 style="font-weight: normal;"> 
				It's lonely isn't it?
			</h4>
		</div>
		<?php
	}
?>