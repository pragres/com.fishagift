<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/menu.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/modalPopup.tpl'); ?>

<!--include specific functions only for the store-->
<script src="<?php echo framework::resolve('static/js/store.js'); ?>" defer="defer"></script>
<script src="<?php echo framework::resolve('static/js/modalPopup.js'); ?>" defer="defer"></script>

<!--changing the interface depending the data from the shipping cart-->
<script type="text/javascript">
	$(document).ready(function(){
		// add item in the session to the shopping cart
		<?php if(!empty($shopping_cart_item)) { ?>
			var id = '<?php echo $shopping_cart_item["ID"]; ?>';
			var price = '<?php echo $shopping_cart_item["PRICE"]; ?>';
			var name = '<?php echo str_replace("'", "\'", $shopping_cart_item["NAMESHORT"]); ?>';
			var image = '<?php echo framework::resolve('static/images/items/'.$shopping_cart_item["IMAGE1"]); ?>';
			addToShoppingCart(id, price, name, image, 'item', 'removeItemFromShoppingCart',false); // add to the interface
			hideItemsList(); // hide the list
		<?php } ?>

		// add paper in the session to the shopping cart
		<?php if(!empty($shopping_cart_paper)) { ?>
			var id = '<?php echo $shopping_cart_paper["ID"]; ?>';
			var name = '<?php echo str_replace("'", "\'", $shopping_cart_paper["DESCRIPTION"]); ?>';
			var image = '<?php echo framework::resolve('static/images/papers/'.$shopping_cart_paper["IMAGE"]); ?>';
			var price = '<?php echo $price_paper; ?>';
			addToShoppingCart(id, price, name, image, 'paper', 'removePaperFromShoppingCart',false); // add to the interface
			hidePapersList(); // hide the list
		<?php } ?>
	});
</script>

<!--section: body-->
<div id="section-body" class="container">
	<div id="products-wrapper" class="col-lg-11 col-md-11 col-sm-11 col-xm-12">

		<!--section: items-->

		<div id="section-items" class="section-item">
			<h1 id="item-header">
				<span class="xout"><span class="badge number-one header-number-size">1</span> <?php echo $i18n['item-header']; ?></span>
				<span class=" badge done"><?php echo $i18n['label-done']; ?></span>
			</h1>

			<div id="item-selected" class="alert alert-success text-left" style="display:none;">
				<div class="wide-text">
					<p><?php echo $i18n['item-msg']; ?></p>
					<p><a href="#" onclick="removeItemFromShoppingCart($('.cart-stand.item .close').get()); return false;"><span class="glyphicon glyphicon-remove-circle"></span> <?php echo $i18n['product-remove']; ?></a></p>
				</div>
			</div>

			<div id="item-list" class="text-left">
				<?php foreach($getItemsByPopularity as $item){ ?>
					<div id="<?php echo $item["ID"]; ?>" class="thumbnail text-center item-stand" draggable="true" ondragstart="drag.dragStart(this);" ondragend="drag.dragEnd();">
						<img class="image" src="<?php echo framework::resolve('static/images/items/'.$item["IMAGE1"]); ?>" alt="<?php echo $item["NAMELONG"]; ?>" style="width:140px;" />
						<b class="name"><?php echo substr($item["NAMESHORT"],0,15); ?></b><br/>
						<span class="badge">$<span class="price"><?php echo number_format((float)$item["PRICE"], 2); ?></span></span>
						<span class="popularity hidden-xs">
						    <?php for($i=1; $i<=$item["STARS"];$i++){ ?>
						    	<i class="glyphicon glyphicon-star orange"></i>
						    <?php } ?>
						    <?php for($i=1; $i<=3-$item["STARS"];$i++){ ?>
						    	<i class="glyphicon glyphicon-star"></i>
						    <?php } ?>
						</span>

						<button type="button" onclick="addItemToShoppingCart(this);" class="hidden-lg hidden-md hidden-sm btn btn-primary btn-xs"><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo $i18n['item-add-cart']; ?></button>

						<div class="item-stand-caption hidden-xs">
							<p class="text-left"><?php echo substr($item["NAMELONG"],0,45); ?></p>
							<a href="<?php echo framework::link_to('store/item&id='.$item["ID"]); ?>" class="btn btn-default btn-xs"><?php echo $i18n['item-see-more']; ?></a>
							<button type="button" onclick="addItemToShoppingCart(this);" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-shopping-cart"></i> <?php echo $i18n['item-add-cart']; ?></button>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>

		<!--section: wrap-->

		<div id="section-wrap" class="section-paper">
			<h1 id="wrap-header">
				<span class="xout"><span class="badge number-two header-number-size">2</span> <?php echo $i18n['wrap-header']; ?></span> 
				<span class="badge done"><?php echo $i18n['label-done']; ?></span>
			</h1>

			<div id="wrap-selected" class="alert alert-success" style="display:none;">
				<div class="wide-text">
					<p><?php echo $i18n['wrap-msg']; ?></p>
					<p><a href="#" onclick="removePaperFromShoppingCart($('.cart-stand.paper .close').get()); return false;"><span class="glyphicon glyphicon-remove-circle"></span> <?php echo $i18n['product-remove']; ?></a></p>
				</div>
			</div>

			<div id="wrap-list" class="section-parent text-left">
				<?php $i=0; foreach($getWrappingPapers as $item) { ?>
					<div id="<?php echo $item['ID']; ?>" accesskey="<?php echo $i; ?>" class="thumbnail text-center wrap-stand accesskey-<?php echo $i; ?>" title="<?php echo $item['NAME']; ?>" draggable="true" ondragstart="drag.dragStart(this);" ondragend="drag.dragEnd();">
						<div class="title hidden "><?php echo $item['NAME']; ?></div>
						<div class="price hidden"><?php echo $price_paper; ?></div>
						<div class="options">
							<a href="#" onclick="addPaperToShoppingCart(this); return false;" class="btn btn-primary btn-xs cart-addible-obj"><?php echo $i18n['btn-pick']; ?></a><!--btn-xs-->
							<a href="#" onclick="openThumbnailViewerModal(this); return false;" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-eye-open"></i></a>
						</div>
						<img class="image" src="<?php echo framework::resolve('static/images/papers/' . $item['IMAGE']); ?>" alt="<?php echo $item['NAME']; ?>" style="width:120px;"/>
					</div>
				<?php $i++; } ?>
			</div>
		</div>


		<!-- next button at the end -->

		<div class="text-center" style="margin-top:30px;">
			<a href="<?php echo framework::link_to('store/send'); ?>" style="min-width:300px; font-size:200%" class="btn btn-success btn-lg checkout-btn" disabled="disabled">
				<?php echo $i18n['next']; ?> <i class="glyphicon glyphicon-share-alt"></i>
			</a>
		</div>
	</div>


	<!--section: shopping cart-->

	<div class="col-lg-1 col-md-1 col-sm-1 hidden-xs">
		<div id="shopping-cart" data-spy="affix" data-offset-top="60">
			<div id="cart-tringle" class="pull-right hidden-xs"></div><!--triangle-->

			<div style="margin-top:10px; padding-bottom:5px;">
				<div class="text-right" style="font-family: monospace;">
					<i class="glyphicon glyphicon-shopping-cart"></i><b style="font-size: 1.2em;"> $<span id="cart-total-price">0</span></b>
					<hr/>
				</div>
			</div>

			<p id="no-items-message"><?php echo $i18n['no-items-msg']; ?></p>
			<div id="cart-contents"></div>
		
			<div id="droppable" ondragover="drag.dragMoveOver(event);" ondragleave="drag.dragMoveOut();" ondrop="drag.drop(event);"><?php echo $i18n['drop']; ?></div>
			<img id="loadingUpdateCart" src="<?php echo framework::resolve('static/graphs/spinner.gif'); ?>" alt="loading" style="margin-left:50px; width:30px; display: none;">

			<div class="text-center" style="margin-top:5px;">
				<hr/>
				<a href="<?php echo framework::link_to('store/send'); ?>" class="btn btn-xs btn-success checkout-btn" disabled="disabled">
					<?php echo $i18n['next']; ?> <i class="glyphicon glyphicon-share-alt"></i>
				</a>
			</div>
		</div>
	</div>
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

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>