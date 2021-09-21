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
});