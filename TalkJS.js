$(document).ready(function(){
	$("#contacts").animate({scrollTop: 0}, "normal");
	
	function send_message(){
		var new_msg = $("#msg").val();
		$.post("Send_Message.php", {msg: new_msg});
		$("#msg").val("");
		$("#chat").animate({scrollTop: $("#chat")[0].scrollHeight - 20}, "normal");
		return false;
	}

	$("#sendm").click(send_message);

	$("#msg").keypress(function(e){
		if(e.keyCode == 13){
			$("#sendm").click(send_message());
		}
		else{
			$("#msg").val($("#msg").val()+e.key);
		}
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
		return false;
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
		return false;
	};
	setInterval(reload_contacts, 500);

	function change_but(){
		if(!$('#msg').val().replace(/\s/g, '').length){
			$('#sendm')[0].disabled = true;
		}
		else{
			$('#sendm')[0].disabled = false;
		}
	}
	setInterval(change_but, 200);

	function reload_active(){
		$.ajax({
			url: "GetOnlineDataInTalk.php",
			cache: false,
			success: function(html){
				$("#active").html(html);
			}
		});
	}
	setInterval(reload_active, 500);
});