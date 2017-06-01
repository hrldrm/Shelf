$(document).ready(function() {
		  	$('#LogoAtNav').css('display', 'none');
				$(window).scroll(function () {
				    console.log($(window).scrollTop());
				    if ($(window).scrollTop() > 58) {
				    	$('.topnav').addClass('navbar-fixed');
				    	$('#LogoAtNav').show();
				    }
					if ($(window).scrollTop() < 58) {
				    	$('.topnav').removeClass('navbar-fixed');
				    	$('#LogoAtNav').css('display', 'none');
				}
			});
		});