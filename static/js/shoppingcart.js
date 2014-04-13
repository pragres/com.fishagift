/**
	@name addToShoppingCart
	@author salvi
	@param id: String, id of the item in the db
	@param price: float, item's price 
	@param name: String, Description of the item to show on hoover
	@param image: URL, to the image of the item
	@param type: Enum (item, paper, card, bag, ornament)
	@param closefunc: callback function to be call when the item is deleted from the cart
	@param saveToSession: Boolen true if the ajax call to save to the session should be executed
	@desc Add an item to the shopping cart. Insert the item in the session variable by Ajax. Creates the icon inside the cart
*/
function addToShoppingCart(id, price, name, image, type, closefunc, saveToSession){
	saveToSession = saveToSession==undefined ? true : false; // optional arguments

	// display loading image in the shopping cart 
	$('#loadingUpdateCart').show();

	// add the item by ajax in the backend
	if(saveToSession){
		var stop = false;
		$.ajax({
			url: "/router.php?package=store&page=addToCart_ajax",
			data: {"id":id,"type":type,"price":price},
			async: false
		}).fail(function(){
			$('#loadingUpdateCart').hide();
			alert("An unknown error happened adding your item to the cart. Please try again"); stop = true; 
		});
		if(stop) return;
	}

	// clone the mold
	var newcart = $('#cart-mold').clone().show().removeAttr('id');

	// insert information
	newcart.attr('id',id).attr('title',name);
	newcart.find('.price').html(Number(price).toFixed(2));
	newcart.find('.type').html(type);
	newcart.find('.image').attr('src',image).attr('alt',name);
	newcart.find('.close').attr('onclick',closefunc + "(this); return false;");
	newcart.addClass(type);

	// append to the shopping cart
	$('#cart-contents').append(newcart);

	// remove the no items messsage
	$('#no-items-message').hide();

	// update the car's total price
	var totalprice = $('#cart-total-price').html();
	var priceToShow = (Number(totalprice) + Number(price)).toFixed(2);
	$('#cart-total-price').html(priceToShow);

	// hide the loading image in the shopping cart 
	$('#loadingUpdateCart').hide();

	// enable the checkout button if conditions are met
	checkReadyToCheckout();

	// jump to the next available section
	if(saveToSession) scrollToTheNextActiveSection('section-'+type);
}


/**
	@name removeFromShoppingCart
	@author salvi
	@param Object: jquery object of the "cart-stand" inside the cart
	@desc Removes an item from the shopping cart. Removes the item from the session variable by Ajax. Deletes the icon inside the cart
*/
function removeFromShoppingCart(obj){

	// display loading image in the shopping cart 
	$('#loadingUpdateCart').show();

	// captured params
	var id = obj.attr('id');
	var type = obj.find('.type').html();
	var price = obj.find('.price').html();

	// remove the item by ajax in the backend
	var stop = false;
	$.ajax({
		url: "/router.php?package=store&page=removeFromCart_ajax",
		data: {"id":id,"type":type,"price":price},
		async: false
	}).fail(function(){ 
		$('#loadingUpdateCart').hide();
		alert("An unknown error happened removing your item from the cart. Please try again"); stop = true; 
	});
	if(stop) return;

	// remove from cart
	$(obj).remove();

	// show no elements message is car is empty
	if($('#cart-contents .cart-stand').length == 0) $('#no-items-message').show();

	// update the car's total price
	var totalprice = $('#cart-total-price').html();
	var priceToShow = (Number(totalprice) - Number(price)).toFixed(2);
	$('#cart-total-price').html(priceToShow);

	// hide the loading image in the shopping cart 
	$('#loadingUpdateCart').hide();

	// disable the checkout button if conditions are not met
	checkReadyToCheckout();

	// jump to the next available section
	scrollToTheNextActiveSection('section-'+type);
}


/** 
	@name animateToShoppingCart
	@author salvi
	@param Object: jquery object or selector of the element to animate
	@desc Creates the animation of moving an object to the shopping cart
*/
function animateToShoppingCart(element){
    element = $(element);
    shoppingcart = $('#shopping-cart');
    var oldOffset = element.offset();
    var newOffset = shoppingcart.offset();

    var temp = element.clone().appendTo('body');
    temp.css('position', 'absolute')
    .css('left', oldOffset.left)
    .css('top', oldOffset.top)
    .css('zIndex', 1000);

    temp.animate( {
        'top': newOffset.top,
        'left':newOffset.left
        }, 'slow', function(){
        element.show();
        temp.remove();
    });
}


/**
	@name checkReadyToCheckout
	@author salvi
	@return true if checkout if possible, false otherwise
	@desc Check if the car has at least an item and a wrapping paper. Disable/Enable all checkout buttons
*/
function checkReadyToCheckout(){
    // check if the conditions are met (one item, one paper)
    var types = [];
    $('.cart-stand .type').each(function(i){
        types[i] = $(this).html();
    });
    var item = $.inArray('item', types) > -1;
    var paper = $.inArray('paper', types) > -1;

    // disable or enable the button depending the conditions
    if(item && paper){
        $('.checkout-btn').removeAttr('disabled');
    }else{
        $('.checkout-btn').attr('disabled','disabled');
    }

    return item && paper;
}


/**
@name scrollToTheNextActiveSection
@author salvi
@desc Find the new active section and scroll. If there are no more active sections, go to the send button
*/
function scrollToTheNextActiveSection(section) {
	var container = $("body");
	var scrollTo = $('.'+section);

	container.animate({ scrollTop: scrollTo.offset().top }, 1000);
}
