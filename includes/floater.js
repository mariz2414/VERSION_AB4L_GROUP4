function floater(floater, path, postvars){
	var div = document.getElementById(floater);
	var exit = document.getElementById("close_floater");
	
	exit.style.opacity = "1";
	exit.style.width = "200%";
	exit.style.height = "200%";
	exit.style.zIndex = "99";
	
	div.style.opacity = "1";
	div.style.zIndex = "100";
	div.style.left = "25%";
	
	var ajax = new XMLHttpRequest();
		ajax.onreadystatechange = function(){
				var response = ajax.responseText;
				div.innerHTML = response;
			}
		ajax.open("POST", path, true);
		
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.setRequestHeader("Content-length", postvars.length);
		ajax.setRequestHeader("Connection", "close");
		
		ajax.send(postvars);
}

function close_floater(){
	var div = document.getElementById("floater");
	var exit = document.getElementById("close_floater");
	
	exit.style.opacity = "0";
	exit.style.width = "200%";
	exit.style.height = "200%";
	exit.style.zIndex = "0";
	
	div.style.opacity = "0";
	div.style.zIndex = "0";
	
}