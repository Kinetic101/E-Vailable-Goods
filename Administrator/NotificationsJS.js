$(document).ready(function(){
	$("#inp").on("keyup", function(){
		var filter = $("#inp").val().toUpperCase();
		for(var i = 0; i < h5.length; i++){
			txt = h5[i].textContent || h5[i].innerText;
		    if (txt.toUpperCase().indexOf(filter) > -1){
		    	h5[i].style.display = "";
		    } 
		    else{
		    	h5[i].style.display = "none";
		    }
		}
	});
})