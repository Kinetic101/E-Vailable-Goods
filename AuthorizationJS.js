$(document).ready(function(){
	var cnt = 0;
	var time_cnt = 0;
	$("#submit").click(function(){
		var pass = $("#pw").val();
		$.ajax({
			url: "Authorization.php",
			data: {
				password: pass,
			},
			cache: false,
			success: function(html){
				$("#message").html(html);
				if($("#message").html().replace(/\s/g, '') == "<p>Incorrectsecuritycode</p>"){
					cnt++;
					swal({
						title: "Incorrect", 
						text: `You still have ${3-cnt} attempt(s) left`, 
						icon: "warning"
					})
				}
				else if($("#message").html().replace(/\s/g, '') == "<p>Authorized</p>"){
					swal({
						title: "Success", 
						text: "You will now be redirected to the market's editting page", 
						icon: "success"
					})
					.then(function(){
						location.href = 'MarketEdit.php';
					});
				}
				if(cnt == 3){
					swal({
						title: "Too Many Attempts", 
						text: "You have inputted too many incorrect attempts, you will now be logged out", 
						icon: "error"
					})
					.then(function(){
						location.href = 'Logout.php';
					});
				}
			}
		});
		return false;
	})

	function change_but(){
		if(!$('#pw').val().replace(/\s/g, '').length){
			$('#submit')[0].disabled = true;
		}
		else{
			$('#submit')[0].disabled = false;
		}
	}
	setInterval(change_but, 10);

	function timer(){
		time_cnt++;
		if(time_cnt >= 300){
			swal({
				title: "Time Out", 
				text: "5 minutes has passed, you will now be logged out", 
				icon: "error"
			})
			.then(function(){
				location.href = 'Logout.php';
			});
		}
	}
	setInterval(timer, 1000);

});