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
});