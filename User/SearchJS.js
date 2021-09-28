$(document).ready(function(){
	$("#sres")[0].style.display = "none";
	$(".inp").focus(function(){
		$(".inp").on("keyup", function(){
			var filter = $(".inp").val().toUpperCase();
			var cont = $("#sres a");
			var x = 0;
			for(var i = 0; i < cont.length; i++){
				txt = cont[i].textContent || cont[i].innerText;
			    if (txt.toUpperCase().indexOf(filter) > -1 && filter.length > 0){
			    	cont[i].style.display = "";
			    	x++;
			    } 
			    else{
			    	cont[i].style.display = "none";
			    }
			}
			if(x > 0){
				$("#sres")[0].style.display = "";
			}
			else{
				$("#sres")[0].style.display = "none";
			}
		})
	})

	$("#sres").blur(function(){
		$("#sres")[0].style.display = "none";
	})
})