<!DOCTYPE html>
<html>
<head>
	<title>Shelf | Log-in</title>
	<link rel="stylesheet" href="<?=base_url()?>assets/css/docstyle.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/login.css">
	<link rel="shortcut icon" href="<?=base_url()?>assets/images/Logo.png">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="ShelfLogo">
			<img id="logo" src="<?=base_url()?>/assets/images/ShelfLogo.png" alt="Shelf">
		</div>
		<div class="contentBox">
			<div id="Login">
				<form method="POST" action="<?=base_url()?>index.php/login/login_user">
					<h1>E-mail</h1>
					<input type="email" id="Name" name="Email" required>
					<h1>Password</h1>
					<input type="password" id="Password" name ="Password" required>	
					<input type="submit" name="Log-in" value="Log-in">
				</form>
				<p class="signUpToShelf" onclick="showBox(0)">Don't have an account? Click to sign up to Shelf!</p>
			</div>
			<div id="Register">
				<p class="fillOut">Fill out the form below to register your account with Shelf. It's free!</p>
				<form name="register" action="<?=base_url()?>index.php/login/register_user" method="POST" onsubmit="validateForm()">
					<h1>E-mail</h1>
					<input type="email" id="Name" name="Email" placeholder="Put in your e-mail address" required>
					<h1>Name</h1>
					<input type="text" id="FName" name ="FName" placeholder="First Name" required pattern="(?=.*[a-z])(?=.*[A-Z]).{1,}">	
					<input type="text" id="LName" name ="LName" placeholder="Last Name" required pattern="(?=.*[a-z])(?=.*[A-Z]).{1,}">	
					<h1>Password (At least 6 characters long, contains at least 1 number, 1 small letter, and 1 capital letter)</h1>
					<input type="password" id="Password" name ="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" placeholder="Create your own password" required>	
					<h1>Confirm Password</h1>
					<input type="password" id="PasswordC" name ="PasswordC" placeholder="Re-type your password" required>	
					<input type="submit" name="Sign-up" value="Sign-up">
				</form>
				<p class="signUpToShelf" onclick="showBox(1)">Already have an account? Click to sign in!</p>
			</div>
		</div>
	</div>

	<script>
		function showBox(id){
			if(id == 0){
				document.getElementById('Login').style.display = 'none';
				document.getElementById('Register').style.display = 'block';
			}else if(id == 1){
				document.getElementById('Login').style.display = 'block';
				document.getElementById('Register').style.display = 'none';
			}
		}
	</script>

	<script>
		function validateForm(){
			var pass = document.forms["register"]["Password"].value; 
			var passC = document.forms["register"]["PasswordC"].value;
    		var errorMessage;
    		if (pass != passC) {
        		alert("Passwords don't match");
    		}
		}
	</script>
</body>
</html>