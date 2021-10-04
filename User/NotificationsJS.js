$(document).ready(function(){
	$("#mread").click(function(){
		$.ajax({
			url: 'MarkAllAsRead.php',
			cache: false,
			method: 'POST',
			data: {
				yes: 1
			},
			success: function(){
				location.href = 'Notifications.php';
			}
		})
	})
})