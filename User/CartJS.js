function check(id){
	if(document.getElementById(id).checked){
		document.getElementById(id+"wow").style.outline = "2px solid #4A7C59";
	}
	else{
		document.getElementById(id+"wow").style.outline = "none";
	}
}

function dec(temp, num, uni){
	if(arr[temp] > 0){
		document.getElementById(num).value = 
			document.getElementById(uni).innerHTML = --arr[temp];
		}
}

function inc(temp, num, uni, val){
	if(arr[temp] < val){
		document.getElementById(num).value = document.getElementById(uni).innerHTML = ++arr[temp];
	}
}	