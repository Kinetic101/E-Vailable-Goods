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

	for(var i = 1; i <= 10; i++){
		var x = $(".a"+i);
		for(var j = 0; j < x.length; j++){
			x[j].disabled = true;
		}
		$("#bry").val("---Select Municipality First---");
	}

	$("#town").on('change', function(){
		for(var i = 0; i <= 10; i++){
			var x = $(".a"+i);
			for(var j = 0; j < x.length; j++){
				if(i == $("#town").val()) x[j].disabled = false;
				else x[j].disabled = true;
			}
		}
		$("#bry").val("");
	})
});