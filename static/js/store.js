/*
 *	COMMON FUNCTIONS FOR ALL THE STORE
 */

function lineOutHeader(headerid){
    $(headerid+' .xout').css('text-decoration','line-through');
    $(headerid+' .optional').hide();
    $(headerid+' .done').show();
	
    // update the counter in the header
    var counter = $(headerid+' .counter').html()*1;
    $(headerid+' .counter').html(counter+1);
}


function resetHeader(headerid){
    $(headerid+' .xout').css('text-decoration','none');
    $(headerid+' .optional').show();
    $(headerid+' .done').hide();

    // update the counter in the header
    var counter = $(headerid+' .counter').html()*1;
    $(headerid+' .counter').html(counter-1);
}


function openThumbnailViewerModal(obj){
	var objstand = $(obj).parents('.thumbnail');

	var sectionparent = $(obj).parents('.section-parent').attr('id');
	var accesskey = objstand.attr('accesskey');
	var title = objstand.find('.title').html();
	var image = objstand.find('.image').attr('src');

	popUpOpen(sectionparent, accesskey, title, image)
}


function addToCartThumbnailViewerModal(){
	var sectionparent = $('#image-configs').attr('section-parent');
	var accesskey = $('#image-configs').attr('access-key');
	var thumbnail = $('#'+sectionparent).find('.accesskey-'+accesskey);
	var cartObjButton = thumbnail.find('.cart-addible-obj');

	$('#thumbnailViewer').modal('hide');
	setTimeout(function(){ // wait 500ms to add the product so the animation can be displayed 
		if(sectionparent=="postcard-list") selectPostCard(cartObjButton);
		if(sectionparent=="wrap-list") addPaperToShoppingCart(cartObjButton);
		if(sectionparent=="bag-list") addBagToShoppingCart(cartObjButton);
	}, 500);
}


/*
 *	FUNCTIONS TO WORK WITH THE ITEMS
 */


function addItemToShoppingCart(obj, animate){
    if(animate==undefined) animate=true;

    // captured params
    var objstand = $(obj).parents('.item-stand');
    var id = objstand.attr('id');
    var price = objstand.find('.price').html();
    var name = objstand.find('.name').html();
    var image = objstand.find('.image').attr('src');

    if(animate){
        // animate item to the shopping cart
        animateToShoppingCart(objstand.find('img'));
	
        // wait 800ms for the animation
        var timer = setInterval(function(){
            // create element in the cart
            addToShoppingCart(id, price, name, image, 'item', 'removeItemFromShoppingCart');
            // hide the list
            hideItemsList();
            // stop timer, excecute only once
            window.clearInterval(timer);
        },800);
    }else{
        // create element in the cart
        addToShoppingCart(id, price, name, image, 'item', 'removeItemFromShoppingCart');
        // hide the list
        hideItemsList();
    }
}


function hideItemsList(){
    $('#item-list').slideUp(
        'fast',
        function(){
            $('#item-selected').show();
            lineOutHeader('#item-header');
        });
}


function removeItemFromShoppingCart(obj){
    // remove from shopping cart
    var objcart = $(obj).parents('.cart-stand');
    removeFromShoppingCart(objcart);

    // clean the text in the header and remove message
    $('#item-selected').hide();
    resetHeader('#item-header');

    // show the list of items
    $('#item-list').slideDown('fast');
}


/*
 *	FUNCTIONS TO WORK WITH THE POSTCARD
 */

var postcardSelectedId = '';
var postcardSelectedTitle = '';
var postcardSelectedImage = '';
var postcardSelectedMessage = '';
 
function selectPostCard(obj){
    var objcard = $(obj).parents('.postcard-stand');
    postcardSelectedId = objcard.attr('id');
    postcardSelectedTitle = objcard.find('.postcard-stand .title').html();
    postcardSelectedImage = objcard.find('.image').attr('src');

    $('#postcard-selected img').attr('src',postcardSelectedImage).attr('alt',postcardSelectedTitle);
    $('#postcard-selected').show();
    $('#postcard-list').hide();
    $('#postcard-configure').slideDown();

    getCardMessage();
}

function unselectPostCard(){
    $('#postcard-selected').hide();
    $('#postcard-list').show();
    $('#postcard-configure').slideUp();
}

function addPostCardToShoppingCart(price){
    // do not allow a blank message
    postcardSelectedMessage = $('#postcard-message').val();
    if(postcardSelectedMessage.length < 5){
        $('#postcard-blank-error').show();
        return false;
    }

    // animate item to the shopping cart
    animateToShoppingCart('#postcard-selected .image');

    // wait 800ms for the animation
    var timer = setInterval(function(){
        // create element in the cart
        addToShoppingCart(postcardSelectedId, price, postcardSelectedTitle, postcardSelectedImage, 'card', 'removePostCardFromShoppingCart');

        // hide the config options and errors, and show done message
        hideCardsList();

        // stop timer, execute only once
        window.clearInterval(timer);
    },800);
}

function hideCardsList(){
    $('#postcard-list').hide();
    $('#postcard-configure').slideUp(
        'fast',
        function(){
            $('#postcard-selected').hide();
            $('#postcard-blank-error').hide();
            $('#postcard-finished').show();
            lineOutHeader('#postcard-header');
        }
        );
}

function removePostCardFromShoppingCart(obj){
    // remove from shopping cart
    var objcart = $(obj).parents('.cart-stand');
    removeFromShoppingCart(objcart);

    // clean the text in the header and remove message
    $('#postcard-finished').hide();
    resetHeader('#postcard-header');

    // show the list of items
    $('#postcard-list').show();
}


/*
 *	FUNCTIONS TO WORK WITH THE WRAPPING PAPER
 */

function addPaperToShoppingCart(obj,animate){
    if(animate==undefined) animate=true;

    // captured params
    var objstand = $(obj).parents('.wrap-stand');
    var id = objstand.attr('id');
    var title = objstand.find('.title').html();
    var price = objstand.find('.price').html();
    var image = objstand.find('.image').attr('src');

    if(animate){
        // animate item to the shopping cart
        animateToShoppingCart(objstand.find('img'));
	
        // wait 800ms for the animation
        var timer = setInterval(function(){
            addToShoppingCart(id, price, title, image, 'paper', 'removePaperFromShoppingCart');
            hidePapersList();
            window.clearInterval(timer);
        },800);
    }else{
        addToShoppingCart(id, price, title, image, 'paper', 'removePaperFromShoppingCart');
        hidePapersList();
    }
}

function hidePapersList(){
    $('#wrap-list').slideUp(
        'fast',
        function(){
            $('#wrap-selected').show();
            lineOutHeader('#wrap-header');
        }
        );
}

function removePaperFromShoppingCart(obj){
    // remove from shopping cart
    var objcart = $(obj).parents('.cart-stand');
    removeFromShoppingCart(objcart);

    // clean the text in the header and remove message
    $('#wrap-selected').hide();
    resetHeader('#wrap-header');

    // show the list of items
    $('#wrap-list').slideDown('fast');
}


/*
 *	FUNCTIONS TO WORK WITH THE GIFT BAGS
 */

function addBagToShoppingCart(obj,animate){
    if(animate==undefined) animate=true;

    // captured params
    var objstand = $(obj).parents('.bag-stand');
    var id = objstand.attr('id');
    var price = objstand.find('.price').html();
    var image = objstand.find('.image').attr('src');

    if(animate){
        // animate item to the shopping cart
        animateToShoppingCart(objstand.find('img'));
	
        // wait 800ms for the animation
        var timer = setInterval(function(){
            addToShoppingCart(id, price, '', image, 'bag', 'removeBagFromShoppingCart');
            hideBagsList();
            // stop timer, excecute only once
            window.clearInterval(timer);
        },800);
    }else{
        addToShoppingCart(id, price, '', image, 'bag', 'removeBagFromShoppingCart');
        hideBagsList();
    }
}

function hideBagsList(){
    $('#bag-list').slideUp(
        'fast',
        function(){
            $('#bag-selected').show();
            lineOutHeader('#bag-header');
        }
        );
}

function removeBagFromShoppingCart(obj){
    // remove from shopping cart
    var objcart = $(obj).parents('.cart-stand');
    removeFromShoppingCart(objcart);

    // clean the text in the header and remove message
    $('#bag-selected').hide();
    resetHeader('#bag-header');

    // show the list of items
    $('#bag-list').slideDown('fast');
}


/*
 *	FUNCTIONS TO WORK WITH THE GIFT ORNAMENTS
 */

function addOrnamentToShoppingCart(obj,animate){
    if(animate==undefined) animate=true;

    // captured params
    var objstand = $(obj).parents('.ornament-stand');
    var id = objstand.attr('id');
    var price = objstand.find('.price').html();
    var image = objstand.find('.image').attr('src');

    // show message if the ornaments list is empty
    ornamentsMessageWhenListEmpty();

    // add number of ornaments picket to the header
    lineOutHeader('#ornament-header');

    if(animate){
        // animate item to the shopping cart
        animateToShoppingCart(objstand.find('.image'));
	
        // wait 800ms for the animation
        var timer = setInterval(function(){
            addToShoppingCart(id, price, '', image, 'ornament', 'removeOrnamentFromShoppingCart');
            // stop timer, excecute only once
            window.clearInterval(timer);
        },800);
    }else{
        addToShoppingCart(id, price, '', image, 'ornament', 'removeOrnamentFromShoppingCart');
    }

    // hide selected ornament
    objstand.removeClass('visible').hide();
}

function ornamentsMessageWhenListEmpty(){
    var counter = $('.ornament-stand.visible').length;
    if(counter == 0) $('#ornament-empty').show();
}

function hideSelectedOrnament(id){
    var objstand = $('#ornament-list #'+id);
    objstand.removeClass('visible').hide();
}

function removeOrnamentFromShoppingCart(obj){
    // remove from shopping cart
    var objcart = $(obj).parents('.cart-stand');
    removeFromShoppingCart(objcart);

    // show ornament back in the list
    var id = objcart.attr('id');
    $('#ornament-list #'+id).addClass('visible').show();

    // clean the text in the header and remove message
    resetHeader('#ornament-header');
    $('#ornament-empty').hide();
}

// TODO: showCardMessage is a better name?
function getCardMessage(){
    var occasion = $("#category").val();
    var stop = false;
    $.ajax({
    	url: "/router.php?package=store&page=getCardMessage_ajax",
        data: {"occasion":occasion},
        async: false,
        complete: function(res, status){
        	if ( status == "success" || status == "notmodified" ){
        		$("#postcard-message").val(res.responseText);
                $("#postcard-message").focus();
        	}
        }
    }).fail(function(){ alert("An unknown error happened. Please try again"); stop = true; });
    if(stop) return;
}