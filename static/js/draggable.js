function Draggable()
{
	this.dragged = null; 
	
	/**
	 * function to be triggered when the drag starts
	 * */
	this.dragStart = function(obj){
		$(obj).css('opacity','0');
		this.dragged = obj;
		$('#droppable').show();
	}

	/**
	 * function to be triggered when the drag ends
	 * */
	this.dragEnd = function(){
		$(this.dragged).css('opacity','1');
		this.dragged = null;
		$('#droppable').css('border-color','orange').css('color','orange').hide();
	}

	/**
	 * function to be triggered when the dragged element moves over the place to drop
	 * */
	this.dragMoveOver = function(ev){
		$('#droppable').css('border-color','#5cb85c').css('color','#5cb85c');
		ev.preventDefault();
	}

	/**
	 * function to be triggered when the dragged element moves out of the place to drop
	 * */
	this.dragMoveOut = function(){
		$('#droppable').css('border-color','orange').css('color','orange');
	}

	/**
	 * function to be triggered when the element is dropped
	 * */
	this.drop = function(ev){
		var target = this.dragged;
		var button = $(target).find('.btn-primary').get();
		var price = $(target).find('.price').html();

		// drop for items
		var isItem = $(target).hasClass('item-stand');
		if(isItem) addItemToShoppingCart(button, false);

		// drop for papers
		var isPaper = $(target).hasClass('wrap-stand');		
		if(isPaper) addPaperToShoppingCart(button, false);

		// drop for bags
		var isBag = $(target).hasClass('bag-stand');
		if(isBag) addBagToShoppingCart(button, false);
		
		// drop for bags
		var isOrnament = $(target).hasClass('ornament-stand');
		if(isOrnament) addOrnamentToShoppingCart(button, false);

		ev.stopPropagation();
	}
}

drag = new Draggable();