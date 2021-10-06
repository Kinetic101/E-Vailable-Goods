function dec(id){
	document.getElementById(id).stepDown();
	check_vals(id);
} 

function inc(id){
	document.getElementById(id).stepUp();
	check_vals(id);
} 

function check_vals(id){
	if(document.getElementById(id).value > 0){
		document.getElementById(id).style.cssText = 'box-shadow: 0 0 0 4px #4A7C59;';
	}
	else{
		document.getElementById(id).style.cssText = 'box-shadow: none;';
	}
}