function liveSearch(str){
	var xhttp;
	if (window.XMLHttpRequest) {
 	   xhttp = new XMLHttpRequest();
    } else {
    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		   	document.getElementById("Result").innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "/Shelf/index.php/search/search_book/" + str, true);
	xhttp.send();
}