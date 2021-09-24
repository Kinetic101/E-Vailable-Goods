$(document).ready(function(){
	function const_reload_notif(){
		$.ajax({
			url: "GetNotificationsCount.php",
			cache: false,
			success: function(html){
				$("#notifsss").html(html);
			}
		});
	};
	setInterval(const_reload_notif, 200);
	
	function const_reload_msg(){
		$.ajax({
			url: "GetAvailableMessages.php",
			cache: false,
			success: function(html){
				$("#here").html(html);
			}
		});
	}
	setInterval(const_reload_msg, 200);
});