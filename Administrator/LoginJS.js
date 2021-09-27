$(document).ready(function(){
	function change_but(){
		if($('#email').val().replace(/\s/g, '').length && $('#pword').val().replace(/\s/g, '').length){
			$('#submit')[0].disabled = false;
		}
		else{
			$('#submit')[0].disabled = true;
		}
	}
	setInterval(change_but, 10);
})