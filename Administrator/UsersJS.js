$(document).ready(function(){
	$("#inp").on("keyup", function(){
		var filter = $("#inp").val().toUpperCase();
		var tr = $("tr");
		for(var i = 1; i < tr.length; i++){
			txt = tr[i].textContent || tr[i].innerText;
		    if (txt.toUpperCase().indexOf(filter) > -1){
		    	tr[i].style.display = "";
		    } 
		    else{
		    	tr[i].style.display = "none";
		    }
		}
	});
})