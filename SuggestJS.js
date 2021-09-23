$(document).ready(function(){
	function change_but(){
		if(!$('#suggest').val().replace(/\s/g, '').length){
			$('#post_sugg')[0].disabled = true;
		}
		else{
			$('#post_sugg')[0].disabled = false;
		}
	}
	setInterval(change_but, 200);
});