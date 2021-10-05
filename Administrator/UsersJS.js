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

function update_market_access(uname, div_id, market){
	var check = 1;
	if($('#'+div_id+market)[0].checked == true){
		check = 0;
	}
	$.ajax({
		url: 'ModifyUser.php',
		cache: false,
		method: 'POST',
		data: {
			uname: uname,
			market: market,
			check: check
		}
	})
}

function del_user(uname, div_id){
	swal({
		icon: "warning",
		text: `Are you sure you want to delete user ${uname}?`,
		dangerMode: true,
		buttons: {
			cancel: true,
			confirm: "Delete User"
		}
	})
	.then(function(resp){
		if(resp == true){
			$.ajax({
				url: "DeleteUser.php",
				cache: false,
				method: "POST",
				data: {
					uname: uname
				},
				success: function(){
					location.href = "Users.php";
				}
			})
		}
	})
}