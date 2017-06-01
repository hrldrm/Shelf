function addBookToShelf(UserID, BookID, ShelfNo){
	var xhttp;
	if (window.XMLHttpRequest) {
 	   xhttp = new XMLHttpRequest();
    } else {
    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		   	alert("Added to shelf!");
		   	$('.addToShelvesModal').hide();
		}
	};
	var path = "/Shelf/index.php/shelves/addBookToShelf/" + BookID + "/" + ShelfNo;
	xhttp.open("GET", path, true);
	xhttp.send();
}