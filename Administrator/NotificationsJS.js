$(document).ready(function(){
	var h5 = $(".userss h5");
		for(var i = 0; i < h5.length; i++){
		h5[i].style.display = "none";
	}
	$("#inp").on("keyup", function(){
		var filter = $("#inp").val().toUpperCase();
		for(var i = 0; i < h5.length; i++){
			txt = h5[i].textContent || h5[i].innerText;
		    if (txt.toUpperCase().indexOf(filter) > -1 && filter.length > 0){
		    	h5[i].style.display = "";
		    } 
		    else{
		    	h5[i].style.display = "none";
		    }
		}
	});
})