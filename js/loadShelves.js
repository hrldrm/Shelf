function loadShelves(UserID, BookID){
	var xhttp;
	if (window.XMLHttpRequest) {
 	   xhttp = new XMLHttpRequest();
    } else {
    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		   	document.getElementById("shelvesContent").innerHTML = this.responseText;
		}
	};
	var path = "/Shelf/index.php/shelves/get_shelves/" + UserID + "/" + BookID;
	xhttp.open("GET", path, true);
	xhttp.send();
}