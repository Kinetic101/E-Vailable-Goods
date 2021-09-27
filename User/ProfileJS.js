$(document).ready(function(){
	function showh(){
		var x = $("#upload_pic")[0];
		if(x.style.display == 'none'){
			x.style.display = 'block';
		}
		else{
			x.style.display = 'none';
		}
		return false;
	}

	$("#magic1").click(showh);
	$("#magic2").click(showh);

	function change_but(){
		if($('#opassw').val().length < 8 || $('#npassw').val().length < 8 || $('#rnpassw').val().length < 8 || !$('#opassw').val().replace(/\s/g, '').length || !$('#npassw').val().replace(/\s/g, '').length || !$('#rnpassw').val().replace(/\s/g, '').length){
			$('#changepass')[0].disabled = true;
		}
		else{
			$('#changepass')[0].disabled = false;
		}
		return false;
	}
	setInterval(change_but, 10);
})