/*
 * FUNCTIONS TO BE INVOKED ONLOAD
 */

$(document).ready(function(){
	// adding js pluggins
	$.fn.riseUp = function()   { $(this).animate({top: '-105px'}, 100); }
	$.fn.riseDown = function() { $(this).animate({top: '0px'}, 500); }
	$.fn.opacityUp = function()   { $(this).animate({opacity: '1'}, 200); }
	$.fn.opacityDown = function() { $(this).animate({opacity: '0.3'}, 400); }


	//adding callback to twitter popover
	var pt = $.fn.popover.Constructor.prototype.show;
	$.fn.popover.Constructor.prototype.show = function () {
		pt.call(this);
		if (this.options.afterShown) {
			this.options.afterShown();
		}
	}

	
	// hover effect for the icons
	$('.item-stand').hover(
		function(){ $(this).find('.item-stand-caption').riseUp(); },
		function(){ $(this).find('.item-stand-caption').riseDown(); }
	);

	
	// hover effect for the postcard and wrapping paper
	$('.postcard-stand, .wrap-stand, .bag-stand, .ornament-stand').hover(
		function(){
			$(this).find('.title').opacityUp();
			$(this).find('.options').opacityUp();
		},
		function(){
			$(this).find('.title').opacityDown();
			$(this).find('.options').opacityDown();
		}
	);

	// add ht5ifv inline validation 
	$('form').ht5ifv({
		classes: {
			valid:''
		},
		select:{
		    restrictions:{
		        required:function ($node){
		            return $node.val() != "";
		        }
		    },
		    events:{
		        validate: 'change.ht5ifv blur.ht5ifv',
		        check: 'change.ht5ifv'
		    }
		}
	});

	// excecute tipTip functionality
	$('.tip').tooltip({});

	// check number of characters on the postcard's message
	$('#postcard-message').bind('keyup paste drop focus', function(e) {
		var min = 5;
		var max = 250;
		var counter = $(this).val().length;

		if(counter <= min){
			$('#characters-counter').css('color','red');
			$('#characters-counter').html(counter);
			return;
		}

		if(counter >= max){
			$('#characters-counter').css('color','red');
			$('#postcard-message').val($(this).val().substring(0,max-1));
			$('#characters-counter').html(counter);
			return;
		}

		$('#characters-counter').css('color','#333');
		$('#characters-counter').html(counter);
	});


	// creating the popover for the menu element Send
	$('#menu-send').popover({
		placement: 'bottom', 
		trigger: 'manual',
		content: function(){ return $('#menu-send-data-content').html(); },
		html: true
	});

	
	// creating the popover for the menu element Send
	$('#menu-login').popover({
		placement: 'bottom', 
		trigger: 'click',
		content: function(){ return $('#menu-login-data-content').html(); },
		html: true,
		afterShown: function() { 
			$('#menu-email').focus();
		}
	});


	// thumbnailViewer
	$('#thumbnailViewer').modal('hide');
});


/*
 * FUNCTIONS TO VALIDATE FORMS
 */

 
function validatePasswordMatch(){
	var newPassword = document.getElementById("newPassword");
	var repeatNewPassword = document.getElementById("repeatNewPassword");

	if (newPassword.value != repeatNewPassword.value) {
		repeatNewPassword.setCustomValidity('Passwords must match');
	}else{
		repeatNewPassword.setCustomValidity('');
	}
}


/* 
 * GENERAL PURPOSE FUNCTIONS 
 */


function blockSendLinkFromMenu(){
	if(checkReadyToCheckout()) return true;
	$('#menu-send').popover('show');
	return false;
}


function animateStoreLoading(){
	// do not show loading message if is jumping inside the "store" page
	var page = $('#loading-store').attr('data-page');
	if(page=="store") return false; 

	// setting loading information
	var i = 0;
	var messages = [
		"Setting up store security",
		"Loading wrapping papers and paper bags",
		"Loading cards and ornaments",
		"Loading store items"
	];

	// show loading message
	$('#loadingMessages').html("Loading general store components");
	$('#loading-store').modal('show');

	// animate loading 
	setInterval(function(){
		$('#loadingMessages').html(messages[i++]);
	},1500);
}