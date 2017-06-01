function retrieveReviews(id){
	var xhttp;
	if (window.XMLHttpRequest) {
 	   xhttp = new XMLHttpRequest();
    } else {
    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		   	document.getElementById("Reviews").innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "/Shelf/index.php/reviews/retrieve/" + id, true);
	xhttp.send();
}