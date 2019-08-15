$(document).ready(function(){
	//scroll to top
	$(window).scroll(function() {    
		var scroll = $(window).scrollTop();
		if (scroll >= 600) {
			$("#nav-top").css({'background-color' :'rgb(237, 0, 90)','color' : 'black'});
		}
		if (scroll == 0){
			$("#nav-top").css({'background-color' :'rgba(0,0,0,0.6)','color' : 'white-space'})
		}

		if( ($(document).height() - $(window).height()) - scroll <50 ){
			$("#btnpositon").css({'background-color' :'white','color' : 'black'})
			$("#btnpositon").show();

		}
		else{
			$("#btnpositon").css({'background-color' :'black','color' : 'white'})
			$("#btnpositon").hide();

		}

	})

	$('#btnpositon').click(function(){
		$('html, body').animate({scrollTop:0}, 'slow');
	})

	$("#scr1").click(function(){
		var elmnt = document.getElementById("contact");
		elmnt.scrollIntoView();
		window.scrollBy(0, 50);
	})
	$("#scr2").click(function(){
		var elmnt = document.getElementById("about");
		elmnt.scrollIntoView();
		window.scrollBy(0, -40);
	})
	$('#scr3').click(function(){
		var elmnt = document.getElementById("topplace");
		elmnt.scrollIntoView();
		window.scrollBy(0, -100);

	})
	$('#createacc').click(function(){
		console.log("xx");
	    $("#myModal").modal("hide");
	    $('#myModal2').modal('show');
	})
})		

