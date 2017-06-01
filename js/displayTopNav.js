function displayTopNavResponsive() {
  	var x = document.getElementById("navId");
	var y = document.getElementById("Search");
	if (x.className === "topnav" || x.className === "topnav navbar-fixed") {
		y.style.float = "none";
		x.className += " responsive";
	}else if(x.className === "topnav responsive"){
		y.style.float = "right";
		x.className = "topnav";
	}else if(x.className === "topnav navbar-fixed responsive"){
		y.style.float = "right";
		x.className = "topnav navbar-fixed";
	}
}