$(document).ready(function(){
	$("#contacts").animate({scrollTop: 0}, "normal");

	$("#sendm").click(function(){
		var new_msg = $("#msg").val();
		$.post("Send_Message.php", {msg: new_msg});
		$("#msg").val("");
		$("#chatbox").animate({scrollTop: $("#chatbox")[0].scrollHeight - 20}, "normal");
		return false;
	});

	function reload_msgs(){
		var oldS = $("#chat")[0].scrollHeight - 20;
		$.ajax({
			url: "GetMsgData.php",
			cache: false,
			success: function(html){
				$("#chat").html(html);
				var newS = $("#chat")[0].scrollHeight - 20;
				if(newS > oldS){
					$("#chat").animate({scrollTop: newS}, "normal");
				}
			}
		});
	};

	setInterval(reload_msgs, 200);

	function reload_contacts(){
		$.ajax({
			url: "GetChatsData.php",
			cache: false,
			success: function(html){
				$("#contacts").html(html);
			}
		});
	};

	setInterval(reload_contacts, 200);
});