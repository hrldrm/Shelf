<!DOCTYPE html>
	<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/navstyle.css">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/bookstyle.css">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/docstyle.css">
		<link rel="stylesheet" href="<?=base_url()?>assets/css/like.css">
		<link rel="shortcut icon" href="<?=base_url()?>assets/images/Logo.png">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<title>Shelf | <?=$Title?></title>
	</head>
	<body>
		<div class="container">
			<div class="addToShelvesModal">
				<div class="asModalContent">
					<span id="asModalClose">&times;</span>
					<h1>Add to My Shelves</h1>
					<div id="shelvesContent"></div>
				</div>
			</div>

			<div class="addToCartModal">
				<div class="acModalContent">
					<span id="acModalClose">&times;</span>
					<h1>This item has been added to your cart!</h1>
				</div>
			</div>

			<div class="searchModal">
				<div class="modalContent">
					<span id="searchModalClose">&times;</span>
					<h1>Search</h1>
					<form>
						<input type="text" placeholder="Title, Author" onkeyup="liveSearch(this.value)">
					</form>
					<div id="Result"></div>
				</div>
			</div>

			<div class="banner">
		 	 	<img class="logo" src="<?=base_url()?>/assets/images/Banner.png" alt="Shelf">
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
				<a style="float: right;" href="<?=base_url()?>index.php/login/logout">Logout</a>
				<a href="#about" style="float: right;"><?=$this->session->userdata('FName')?></a>
				<a id="Search" style="float: right;" href="javascript:void(0);">Search</a>
				<a href="javascript:void(0);" class="icon" onclick="displayTopNavResponsive()">&#9776;</a>	
			</div>

			<div class="BookInfo">
				<img class='Cover' src="<?=$bookLink?>">
				<h1 class="text"><?=$Title?></h1>
				<h2 class="text"><?=$Author?></h2>
				<h2 class="text">ISBN: <?=$ISBN?></h2>
				<h2 class="text"><?=$Synopsis?></h2>
			</div>

			<button id="AddToCart">Add to Cart</button>
			<button id="AddToShelves">Add to My Shelves</button>

			<div id="Reviews">
				<div id="ReviewContent"></div>
				<div id="AddReview">
					<form method='POST' action='/Shelf/index.php/review/insert/'>
						<input type='hidden' name='ID' value=<?=$ID?>>
						<label>
							<input type='radio' name='vote' value='1' required />
							<img src='/Shelf/assets/images/like.png'>
						</label>
						<label>
							<input type='radio' name='vote' value='-1' required/>
							<img src='/Shelf/assets/images/dislike.png'>
						</label>
						<input type='text' name='review' placeholder='Enter your review' required>
						<input type='submit' value='Submit'>
					</form>
				</div>
			</div>
<!-- 
			<div class="footer">
				<div class="footerContent">
					<p><span class="footerTitle">Shelf</span></p>
				</div>
			</div>	 -->
		</div>		

		<script>
			var xhttp;
			if (window.XMLHttpRequest) {
		 	   xhttp = new XMLHttpRequest();
		    } else {
		    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				   	document.getElementById("ReviewContent").innerHTML = this.responseText;
				}
			};
			xhttp.open("GET", "/Shelf/index.php/reviews/retrieve/" + <?=$ID?>, true);
			xhttp.send();			
		</script>

		<script>
			var xhttp;
			if (window.XMLHttpRequest) {
		 	   xhttp = new XMLHttpRequest();
		    } else {
		    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if(this.responseText == "true"){
						document.getElementById("AddReview").innerHTML = "<p>You have already rated this book</p>";
					}
				}
			};
			xhttp.open("GET", "/Shelf/index.php/reviews/if_reviewed/" + "<?=$this->session->userdata("UserID")?>" + "/" + "<?=$ID?>", true);
			xhttp.send();
		</script>

		<script>
			function updateComments(){
				var xhttp;
				if (window.XMLHttpRequest) {
			 	   xhttp = new XMLHttpRequest();
			    } else {
			    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
					   	document.getElementById("ReviewContent").innerHTML = this.responseText;
					}
				};
				xhttp.open("GET", "/Shelf/index.php/reviews/retrieve/" + <?=$ID?>, true);
				xhttp.send();	
			}
		</script>

		<script>
				$('#AddToCart').click(function(){
					var xhttp;
					if (window.XMLHttpRequest) {
				 	   xhttp = new XMLHttpRequest();
				    } else {
				    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							$('.addToCartModal').show();
						}
					};
					$path = "/Shelf/index.php/cart/addBookToCart/" + '<?=$ID?>';
					xhttp.open("GET", $path, true);
					xhttp.send();	
				});

				$('#acModalClose').click(function(){
					$('.addToCartModal').hide();
				});
			</script>

		<script src="<?=base_url()?>assets/js/ShelvesModal.js"></script>

		<script src="<?=base_url()?>assets/js/loadShelves.js"></script>

		<script>
			loadShelves("<?=$this->session->userdata('UserID')?>", "<?=$ID?>");
		</script>

		<script src="<?=base_url()?>assets/js/addToShelf.js"></script>		

		<script src="<?=base_url()?>assets/js/docReady.js"></script>
		
		<script src="<?=base_url()?>assets/js/displayTopNav.js"></script>

		<script src="<?=base_url()?>assets/js/searchModal.js"></script> 	

		<script src="<?=base_url()?>assets/js/LiveSearch.js"></script>
	</body>
</html>