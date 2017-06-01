<!DOCTYPE html>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/navstyle.css">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/docstyle.css">
		<link rel="shortcut icon" href="<?=base_url()?>assets/images/Logo.png">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<title>Shelf | Home</title>
	</head>

	<body>
		<!-- <script>
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
					if(this.readyState = 4 && this.status == 200){
						displayBooks(this);
					}
				};
				xhttp.open("GET", "/Shelf/data/Books.xml", true);
				xhttp.send();

			function displayBooks(xml){
				var x, i, xmlDoc, txt;
				xmlDoc = xml.responseXML;
				txt="";
			    x = xmlDoc.getElementsByTagName("Book")[0];
				xlen = x.childNodes.length;
				y = x.firstChild;
				for (i = 0; i <xlen; i++) {
				   if (y.nodeType == 1) {
				    txt += y.nodeName + "<br>";
				  }
				  y = y.nextSibling;
				}
			    document.getElementById("demo").innerHTML = txt; 
			}
		</script> -->
		<div class="container">
			<div class="searchModal">
				<div class="modalContent">
					<span id="searchModalClose">&times;</span>
					<h1>Search</h1>
					<form>
						<input type="text" placeholder="Title, Author, ISBN" onkeyup="liveSearch(this.value)">
					</form>
					<div id="Result"></div>
				</div>
			</div>

			<div class="banner">
		 	 	<img class="logo" src="<?=base_url()?>assets/images/Banner.png" alt="Shelf">
		 	 	<h1>Where your next book awaits!</h1>
	 	 	</div>

			<div id="navId" class="topnav">
				<a href="#" class="NavLogo" title="Go back to top">
		 	 		<img id="LogoAtNav" src="<?=base_url()?>assets/images/Logo.png">
		 		</a>
				<a href="<?=base_url()?>" class="active">Home</a>
	 	 		<a href="<?=base_url()?>index.php/cart">My Cart</a>
				<a href="<?=base_url()?>index.php/shelves/">My Shelves</a>
				<a href="#contact">Recommended</a>
				<a style="float: right;" href="<?=base_url()?>index.php/login/logout">Logout</a>
				<a href="#about" style="float: right;"><?=$this->session->userdata('FName')?></a>
				<a id="Search" style="float: right;" href="javascript:void(0);">Search</a>
				<a href="javascript:void(0);" class="icon" onclick="displayTopNavResponsive()">&#9776;</a>	
			</div>

			<div class="Fantasy">
				
			</div>

			<div class="footer">
				<div class="footerContent">
					<p><span class="footerTitle">Shelf</span></p>
				</div>
			</div>	
		</div>

	<script>
		var emailSent = "<?=$this->session->tempdata('SentEmail')?>";
		if(emailSent == "true"){
			alert("Hi <?=$this->session->userdata('FName')?>!\nWe've sent you an e-mail at ")
		}
	</script>

	<script src="<?=base_url()?>assets/js/docReady.js"></script>
	
	<script src="<?=base_url()?>assets/js/displayTopNav.js"></script>

	<script src="<?=base_url()?>assets/js/searchModal.js"></script> 	

	<script src="<?=base_url()?>assets/js/liveSearch.js"></script>

	</body>
</html>