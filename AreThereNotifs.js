$(document).ready(function(){
	function are_there_notifs(){
		$.ajax({
			url: "AreThereNotifs.php",
			cache: false,
			success: function(html){
				$("#bello").html(html);
			}
		});
	}
	setInterval(are_there_notifs, 100);
});