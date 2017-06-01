<!DOCTYPE html>

<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/navstyle.css">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/docstyle.css">
		<link rel="shortcut icon" href="<?=base_url()?>assets/images/Logo.png">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<title>Shelf | About</title>
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
				<a href="<?=base_url()?>">Home</a>
	 	 		<a href="<?=base_url()?>index.php/cart">My Cart</a>
				<a href="<?=base_url()?>index.php/shelves">My Shelves</a>
				<a href="#contact">Recommended</a>
				<a href="<?=base_url()?>index.php/about" class="active">About</a>
				<a style="float: right;" href="<?=base_url()?>index.php/login/logout">Logout</a>
				<a href="#about" style="float: right;"><?=$this->session->userdata('FName')?></a>
				<a id="Search" style="float: right;" href="javascript:void(0);">Search</a>
				<a href="javascript:void(0);" class="icon" onclick="displayTopNavResponsive()">&#9776;</a>	
			</div>

			<div class="about" style="margin-top:50px; margin-left:30pt; margin-right:30pt; font-family:'Raleway',sans-serif; font-size: 20px">
				<img style="width: 30%; height: 30%;" src="<?=base_url()?>assets/images/ShelfLogo.png">
				<div style="display: block;">
				Founded by Harold Mansilla, Virgilio Mendoza III and Jeremiah Sean De Guzman, Shelf aims to give its customers a pleasing and convenient experience in online book shopping. Shelf also aims to promote a safe environment where people can share their opinions about the books they love.
				</div>
				<h2 style="text-align: center; color: #00BEBE;">The Founders</h2>
				<div>
					<h3 style="text-align: center; color: #CCB33B;">Harold Mansilla</h3>
					<img src="<?=base_url()?>assets/images/Harold.JPG" align="left" alt="Harold" style="max-width:10%;max-height:10%;transform: rotate(90deg);">
					Harold doesn't really like to tell stuff about himself. He hasn't read books since August 2015 and watched anime since January 2016. As of now, he entertains himself by studying <i>(that's a lie)</i> and binge-watching a whole lot of TV Series.<br>
					<b>Favorite book</b>: The Catcher in the Rye<br>
					<b>Favorite genres</b>: Sci-Fi/Fantasy, Mystery, Adventure, Angst, Classics
				</div>
				<div>
					<h3 style="text-align: center; color: #CCB33B;">Virgilio Mendoza III</h3>
					<img src="<?=base_url()?>assets/images/VJ.JPG" align="left" alt="VJ" style="max-width:10%;max-height:10%;transform: rotate(90deg);">
					Virgilio (VJ) is small, has dark circles around his eyes, eats junk food, and retreats when approached by society. <s>VJ is a raccoon.</s> <br>
					<b>Favorite Book</b>: Inkheart, it was his first stolen book from library <br>
					<b>Fav Genres</b>: Fantasy, Adventure <br>
				</div>
				<div>
					<h3 style="text-align: center; color: #CCB33B;">Jeremiah Sean De Guzman</h3>
					<img src="<?=base_url()?>assets/images/Jere.JPG" align="left" alt="VJ" style="max-width:10%;max-height:10%;transform: rotate(90deg);">
					Jeremiah (Jere) is a nerd in... several ways. He tends to be arrogant most of the time, but he tries to be nice sometimes. He likes video games, anime, cartoons and math. <br>
					<b>Favorite Book</b>: Farenheit 451, he enjoyed clutching the book report of this book the most <br>
					<b>Fav Genres</b>: Fantasy, Adventure <br>
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