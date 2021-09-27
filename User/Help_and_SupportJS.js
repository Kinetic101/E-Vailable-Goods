$(document).ready(function(){
	$("#contacts").animate({scrollTop: 0}, "normal");
	
	function send_message(){
		var new_msg = $("#msg").val();
		$.post("Send_MessageWDevs.php", {msg: new_msg});
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
			url: "GetMsgDataWDevs.php",
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

	function change_but(){
		if(!$('#msg').val().replace(/\s/g, '').length){
			$('#sendm')[0].disabled = true;
		}
		else{
			$('#sendm')[0].disabled = false;
		}
	}
	setInterval(change_but, 10);

	$("#help1").click(function(){
		swal({
			title: "How to Change Profile Picture?", 
			text: "Click your profile picture in the Profile page then click choose file and then upload.", 
			icon: "info"
		});
	});

	$("#help2").click(function(){
		swal({
			title: "How Can I Access the Edit Page?", 
			text: "First, you should be a market administrator. You have to contact the website administrators for you to have access to the pages. Verfication checks will then be done on you to ensure website security.", 
			icon: "info"
		});
	})

	$("#help3").click(function(){
		swal({
			title: "How Can I Change My Name?", 
			text: "First of all, you can't change any of your credentials.", 
			icon: "info"
		});
	})

	$("#help4").click(function(){
		swal({
			title: "Is Account Deletion Available?", 
			text: "Yes but you'll have to contact the website administrators and they'll do it for you. However, account deletion is not possible if you have pending orders.", 
			icon: "info"
		});
	})

	$("#help5").click(function(){
		swal({
			title: "How to Order?", 
			text: "Go to the Buy page which can be seen at the top of each page. Orders are paid via COD (Cash on Delivery) since we currently do not support e-payments yet.", 
			icon: "info"
		});
	})

	$("#help6").click(function(){
		swal({
			title: "How to Talk with Others?", 
			text: "Simply pick someone to chat in the Active Now sidebar then click Message. The two of you can now chat with each other. Please observe proper internet etiquette.", 
			icon: "info"
		});
	})

	$("#help7").click(function(){
		swal({
			title: "How to Cancel Pending Orders?", 
			text: "You cannot cancel pending orders.", 
			icon: "info"
		});
	})

	$("#help8").click(function(){
		swal({
			title: "How to Change Password?", 
			text: "Simply go to the Profile page, a form is available there for you to change your account's password.", 
			icon: "info"
		});
	})

	$("#help9").click(function(){
		swal({
			title: "Who are The People Behind This Website?", 
			text: "Please go to the About page to read about us or reach us through at evailablegoods@gmail.com", 
			icon: "info"
		});
	})
});