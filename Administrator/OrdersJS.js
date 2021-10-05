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

function update_order(uname, div_id, id){
	var check = 1;
	if($('#'+div_id)[0].checked == true){
		$('#'+div_id)[0].disabled = true;
		check = 0;
		$.ajax({
			url: 'ModifyOrder.php',
			cache: false,
			method: 'POST',
			data: {
				uname: uname,
				id: id
			}
		})
	}
}