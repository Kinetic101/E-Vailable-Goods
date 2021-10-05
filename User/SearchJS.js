$(document).ready(function(){
	$("#sres")[0].style.display = "none";
	$(".inp").focus(function(){
		$(".inp").on("keyup", function(){
			var filter = $(".inp").val();
			$.ajax({
				url: 'GetSearchRes.php',
				cache: false,
				method: "GET",
				data: {
					filter: filter
				},
				success: function(response){
					$("#sres").html(response);
					if(response.length > 0){
						$("#sres")[0].style.display = "";
					}
					else{
						$("#sres")[0].style.display = "none";
					}
					return false;
				}
			})
		})
	})
})