$(document).ready(function(){
	function change_but(){
		if($('#uname').val().replace(/\s/g, '').length && $('#pword').val().replace(/\s/g, '').length){
			$('.submit')[0].disabled = false;
		}
		else{
			$('.submit')[0].disabled = true;
		}
		return false;
	}
	setInterval(change_but, 10);

	$(".showp").click(function(){
		if($("#pword")[0].type == 'password'){
			$("#pword")[0].type = 'text';
			$('#showbutt')[0].className = "fas fa-eye";
		}
		else{
			$("#pword")[0].type = 'password';
			$('#showbutt')[0].className = "fas fa-eye-slash";
		}
		return false;
	})

})