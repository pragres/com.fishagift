<?php 
	$lang = framework::session_get('language');
	include_once framework::resolve("packages/base/i18n/$lang/cart.php");
?>

<script type="text/javascript">
	function dragOverElement(element,ev){
	}
</script>

<!--section: shopping cart-->
<div id="shopping-cart">
	<div id="cart-tringle" class="pull-right"></div><!--triangle-->

	<div style="margin-top:10px; padding-bottom: 5px;">
		<span class="badge" ><i class="glyphicon glyphicon-shopping-cart"></i> $<span id="cart-total-price">0</span></span>
		<a id="checkout" href="<?php echo framework::link_to('store/send'); ?>" class="btn btn-mini btn-success pull-right" style="margin-top:-30px;" disabled="disabled">
			<?php echo $i18n['send']; ?> <i class="glyphicon glyphicon-share-alt"></i>
		</a>
	</div>

	<p id="no-items-message"><?php echo $i18n['no-items-msg']; ?></p>
	<div id="cart-contents"></div>

	<div id="droppable" ondragover="drag.dragMoveOver(event);" ondragleave="drag.dragMoveOut();" ondrop="drag.drop(event);"><?php echo $i18n['drop']; ?></div>
	<img id="loadingUpdateCart" src="<?php echo framework::resolve('static/graphs/spinner.gif'); ?>" alt="loading" style="margin-left:50px; width:30px; display: none;">
</div>

<!--a hidden mold to make new cart elements-->
<div id="cart-mold" class="thumbnail cart-stand text-center" style="display:none;" title="">
	<div class="type hidden"></div>
	<div class="pull-right">
		<a class="close" href="#" onclick="removeItemFromShoppingCart(this); return false;" class="btn btn-mini pull-right"><i class="glyphicon glyphicon-remove"></i></a><br/>
		<span class="badge"><span class="price"></span></span>
	</div>
	<img class="image" src="" alt=""/>
</div>