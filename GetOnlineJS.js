$(document).ready(function(){
	var cnt = 0;

	function reload_active(){
		$.ajax({
			url: "GetOnlineData.php",
			cache: false,
			success: function(html){
				$("#active").html(html);
			}
		});
	}

	setInterval(reload_active, 500);
});