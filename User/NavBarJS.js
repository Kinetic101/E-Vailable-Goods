$(document).ready(function(){
	$("#burg").click(function(){
		var x = $("#nav")[0];
		if(x.style.display == 'none'){
			x.style.display = 'block';
		}
		else{
			x.style.display = 'none';
		}
		return false;
	});
});

$(document).ready(function(){
	$("#disp").click(function(){
		var y = $("#drop")[0];
		if(y.style.display == 'none'){
			y.style.display = 'block';
		}
		else{
			y.style.display = 'none';
		}
		return false;
	});
});