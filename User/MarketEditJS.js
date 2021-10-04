$(document).ready(function(){
	$("#show").click(function(){
		var x = $("#float_form")[0];
		if(x.style.display == 'none'){
			x.style.display = 'block';
		}
		else{
			x.style.display = 'none';
		}
		return false;
	});
});

function dec(id){
	document.getElementById(id).stepDown();
}

function inc(id){
	document.getElementById(id).stepUp();
}