$(window).on("load", function(){
	function stop_loading(){
		$("#loading")[0].style.display = "none";
		$("#loading")[0].style.height = "0";
		$("#loading")[0].style.width = "0";
		$("body")[0].style.overflow = "auto";
	}
	stop_loading();
});