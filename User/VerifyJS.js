$(document).ready(function(){
	var cnt_error = 0;
	var curr_time = 0;
	function check(){
		var otp_in = $("#otp").val();
		$.ajax({
			url: "CheckOTP.php",
			cache: false,
			method: "POST",
			data: {
				otp: otp_in
			},
			success: function(response){
				if(RegExp('\\berror\\b').test(response)){
					cnt_error++;
					swal({
						title: "Incorrect OTP", 
						text: `You have entered an incorrect OTP, ${5-cnt_error} attempt(s) left`, 
						icon: "warning"
					});
					$("#otp").val("");
				}
				else if(RegExp('\\bsuccess\\b').test(response)){
					swal({
						title: "OTP Verification Success", 
						text: "You have successfully entered the correct OTP therefore, you have successfully signed up!", 
						icon: "success"
					})
					.then(function(){
						location.href = 'Profile.php';
					});
				}
				if(cnt_error == 5){
					swal({
						title: "Too Many Incorrect Attempts", 
						text: "You have inputted too many incorrect attempts, you will now be redirected back to the Sign Up page!", 
						icon: "error"
					})
					.then(function(){
						location.href = 'SignUp.php';
					});
				}
				return false;
			}
		});
	}

	function timer(){
		curr_time++;
		if(curr_time >= 300){
			swal({
				title: "OTP Expired", 
				text: "5 minutes has passed therefore, the OTP we provided you has now expired", 
				icon: "error"
			})
			.then(function(){
				location.href = 'SignUp.php';
			});
		}
	}
	setInterval(timer, 1000);

	$("#otp").keypress(function(e){
		if(e.keyCode == 13){
			$("#submit").click(check());
		}
		else{
			if($("#otp").val().length < 6 && e.keyCode >= 48 && e.keyCode <= 57){
				$("#otp").val($("#otp").val()+e.key);
			}
		}
		return false;
	})

	function change_but(){
		if($("#otp").val().length != 6){
			$("#submit")[0].disabled = true;
		}
		else{
			$("#submit")[0].disabled = false;
		}
	}
	setInterval(change_but, 10);

});