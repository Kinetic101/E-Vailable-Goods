$(document).ready(function(){
	$("#show").click(function(){
		var x = $("#cins")[0];
		if(x.style.display == 'none'){
			x.style.display = 'block';
		}
		else{
			x.style.display = 'none';
		}
		return false;
	});
});