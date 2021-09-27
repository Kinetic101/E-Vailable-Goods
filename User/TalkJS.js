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
			if($('#msg').val().replace(/\s/g, '').length){
				$("#sendm").click(send_message());
			}
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
				if($("#chat").html().replace(/\s/g, '') != html.replace(/\s/g, '')){
					$("#chat").html(html);
				}
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
				if($("#contacts").html().replace(/\s/g, '') != html.replace(/\s/g, '')){
					$("#contacts").html(html);
				}
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
	setInterval(change_but, 10);

	function reload_active(){
		$.ajax({
			url: "GetOnlineDataInTalk.php",
			cache: false,
			success: function(html){
				if($("#active").html().replace(/\s/g, '') != html.replace(/\s/g, '')){
					$("#active").html(html);
				}
			}
		});
	}
	setInterval(reload_active, 500);
});