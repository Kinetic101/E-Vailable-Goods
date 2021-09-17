<!DOCTYPE html>
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

	$_SESSION["market"] = "";
	$_SESSION["product"] = "";
	$_SESSION["buy_arr"] = array();

	if(isset($_GET["user"])){
		$_SESSION["visit_user"] = $_GET["user"];
	}
	else{
		$_SESSION["visit_user"] = "";
	}

	$msg = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(!empty($_POST["msg"])){
			$date = date("Y-m-d H:i:s");
			$insert = "INSERT INTO `messages`
						(`from_user`, `to_user`, `message`, `time`)
						VALUES('$_SESSION[usern]', '$_SESSION[visit_user]', '$_POST[msg]', '$date')";
			$conn -> query($insert);
			header("Location: Talk.php?user=$_SESSION[visit_user]");
	}
		}
?>

<script type = "text/javascript">
	function go(){
		setInterval(function req(){
						var obj = document.getElementById("chatbox");
						var oldS = obj.scrollHeight-20;
						var xmlhttp;
						if(window.XMLHttpRequest){
							xmlhttp = new XMLHttpRequest();
						}
						else{
							xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange = function(){
							if(this.readyState == 4 && this.status == 200){
								var newS = obj.scrollHeight-20;
								if(newS > oldS) {
									obj.scrollTop = newS;
								}
								document.getElementById("chatbox").innerHTML = this.responseText;
							}
						}
						xmlhttp.open("GET", "GetMsgData.php?us=<?php echo $_SESSION["visit_user"];?>", true);
						xmlhttp.send();
					}, 10);
	}
</script>	

<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<link rel="stylesheet" type="text/css" href="TalkCSS.css">
	<title>Talk</title>
</head>
<body>

	<header>
		<nav>
			<ul class="links">
				<li><a href="Research.php">Buy</a></li>
				<li><a href="Talk.php" id = "press">Talk</a></li>
				<li><a href="Edit.php">Edit</a></li>
				<li><a href="Suggest.php">Suggest</a></li>
				<li><a href="About.php">About</a></li>
			</ul>
		</nav>
		<a href = "Research.php" class = "evg">E-Vailable Goods</a>
		<ul>
		<li class = "dropdown"><a href = "Profile.php" class="pic">
			<div class="prof"><img src = "<?php echo $_SESSION["prof_pic"]?>" alt = "Avatar" class = "dp">
			</div>
		</a>
		<div class="dlinks">
      			<a href="Profile.php">Profile</a>
      			<a href="#">Help & Support</a>
      			<a href="Logout.php">Logout</a>
    	</div>
    	</li>
		</ul>

	</header>

	<div id = "contacts">
		<?php
			$check = array();
			$select = "SELECT *
						FROM `messages`
						WHERE `from_user` = '$_SESSION[usern]' OR `to_user` = '$_SESSION[usern]' ORDER BY `time` DESC";
			$res = $conn -> query($select);
			while($row = $res -> fetch_assoc()){
				if($row["from_user"] == $_SESSION["usern"]){
					if(!array_key_exists($row["to_user"], $check)){
						echo "<a href = Talk.php?user=$row[to_user]>".$row["to_user"]."<br></a>";
					}
					$check[$row["to_user"]] = True;
				}
				else{
					if(!array_key_exists($row["from_user"], $check)){
						echo "<a href = Talk.php?user=$row[from_user]>".$row["from_user"]."<br></a>";
					}
					$check[$row["from_user"]] = True;
				}
			}
		?>
	</div>

	<div id = "chatbox">
		<?php
			if($_SESSION["visit_user"] == ""){
				echo "Please select a chat.";
			}
			else{
				echo "<script type = text/javascript>go();</script>";
			}
		?>
	</div>
	<div id = "send">
		<form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?user=".$_SESSION["visit_user"]);?>">
			<input type = "text" name = "msg" placeholder = "Type your message here." size = "100%">
			<input type = "submit" name = "send" value = "Send"  >
		</form>
	</div>
</body>
</html>