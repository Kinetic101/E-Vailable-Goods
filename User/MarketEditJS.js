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

function dec(id, val){
	document.getElementById(id).stepDown();
	check_vals(id, val);
}

function inc(id, val){
	document.getElementById(id).stepUp();
	check_vals(id, val);
}

function check_vals(id, val){
	if(document.getElementById(id).value != val){
		document.getElementById(id).style.cssText = 'box-shadow: 0 0 0 4px #4A7C59;';
	}
	else{
		document.getElementById(id).style.cssText = 'box-shadow: none;';
	}
}