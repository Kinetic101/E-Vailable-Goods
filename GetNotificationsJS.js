$(document).ready(function(){
	function const_reload(){
		$.ajax({
			url: "GetNotificationsCount.php",
			cache: false,
			success: function(html){
				$("#notifsss").html(html);
				setTimeout(function(){
					$("#bell")[0].style.color = "white";
				},500);
			}
		});
	};
	setInterval(const_reload, 1000);

	function const_reload_msg(){
		$.ajax({
			url: "GetAvailableMessages.php",
			cache: false,
			success: function(html){
				$("#here").html(html);
				setTimeout(function(){
					$("#talk")[0].style.color = "white";
				},500);
			}
		});
	}
	setInterval(const_reload_msg, 1000);
});