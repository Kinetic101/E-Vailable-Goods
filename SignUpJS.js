$(document).ready(function(){
	function change_but(){
		if($('#uname').val().replace(/\s/g, '').length && $('#email').val().replace(/\s/g, '').length && $('#pword').val().replace(/\s/g, '').length && $('#fname').val().replace(/\s/g, '').length && $('#lname').val().replace(/\s/g, '').length && ($('#admin').val().replace(/\s/g, '').length || $('#cust').val().replace(/\s/g, '').length)){
			$('#submit')[0].disabled = false;
		}
		else{
			$('#submit')[0].disabled = true;
		}
	}
	setInterval(change_but, 10);
})