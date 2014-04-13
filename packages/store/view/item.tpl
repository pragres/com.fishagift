<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/menu.tpl'); ?>

<!-- including magnifier glass plugin -->
<script type="text/javascript" src="<?php echo framework::resolve('static/libs/jquery.magnifier/jquery.magnifier.js'); ?>"></script>

<script type="text/javascript">
	function addItemToCart(){
		var id = '<?php echo $getItemByID["ID"]; ?>';
		var price = '<?php echo $getItemByID["PRICE"]; ?>';
		window.location = "<?php echo framework::link_to('store/addToCart_submit'); ?>&id="+id+"&type=item&price="+price;
	}
</script>

<!--section: body-->
<div id="section-body" class="container">
	<div class="col-lg-12">
		<!--section: item-->
		<div id="section-item">
			<h1><?php echo $getItemByID["NAMELONG"]; ?></h1>
			<div class="row">
				<div class="col-lg-4 col-md-5 col-sm-6 col-xm-12">
					<div id="carousel" class="carousel slide" style="max-width: 315px;">
						<!-- indicators -->
						<?php if(count($pictures) > 1) { ?>
							<ol class="carousel-indicators">
								<?php foreach($pictures as $i=>$pic) { ?>
									<li data-target="#carousel" data-slide-to="<?= $i ?>" <?php if($i==0){ ?>class="active"<?php } ?>></li>
								<?php } ?>
							</ol>
						<?php } ?>

						<!-- slides -->
						<div class="carousel-inner">
							<?php foreach($pictures as $i=>$pic) { ?>
								<div class="item <?php if($i==0){ ?>active<?php } ?>">
									<img class="magnify" data-magnifyby="2" style="width:364px; height:280px;" src="<?php echo framework::resolve('static/images/items/'.$getItemByID["IMAGE".($i+1)]); ?>" alt="<?php echo $getItemByID["NAMELONG"]; ?>"/>
								</div>
							<?php } ?>
						</div>

						<!-- controls -->
						<?php if(count($pictures) > 1) { ?>
							<a class="left carousel-control" href="#carousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
							<a class="right carousel-control" href="#carousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
						<?php } ?>
					</div>
				</div>
				<div class="col-lg-8  col-md-7 col-sm-6 col-xm-12">
					<div class="visible-xs" style="margin-top:30px;"></div>
					<p><?php echo $i18n['item-name']; ?>: <?php echo $getItemByID["NAMELONG"]; ?></p>
					<p><?php echo $i18n['item-price']; ?>: $<?php echo $getItemByID["PRICE"]; ?></p>
					<p>
						<span class="tip" title="<?php echo $i18n['item-popularity-title']; ?>"><?php echo $i18n['item-popularity']; ?>:</span>
						<span class="popularity">
							<?php for($i=1; $i<=$getItemByID["STARS"];$i++){ ?>
							<i class="glyphicon glyphicon-star orange"></i>
							<?php } ?>
							<?php for($i=1; $i<=3-$getItemByID["STARS"];$i++){ ?>
							<i class="glyphicon glyphicon-star"></i>
							<?php } ?>
						</span>
					</p>
					<p><?php echo $i18n['item-category']; ?>: <?php echo $getItemByID["CATEGORY"]; ?></p>
					<p><?php echo $i18n['item-stock-msg1']; ?> <?php echo $getItemByID["STOCK"]; ?> <?php echo $i18n['item-stock-msg2']; ?></p>

					<div style="margin-top: 50px;">
						<a onclick="animateStoreLoading();" href="<?php echo framework::link_to('store/store'); ?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-arrow-left"></span> <?php echo $i18n['btn-back']; ?></a>
						<button class="btn btn-primary btn-lg" onclick="addItemToCart();" type="button" style="width: 200px;"><span class="glyphicon glyphicon-shopping-cart"></span> <?php echo $i18n['btn-addtocart']; ?></button>
					</div>
				</div>
			</div>

			<!-- section: description -->
			<h1><?php echo $i18n['description-header']; ?></h1>
			<p class="wide-text"><?php echo $getItemByID["DESCRIPTION"]; ?></p>

			<!-- section: similar items, show if it has -->
			<?php if(count($getSimilarItems) > 0) { ?>
				<h1><?php echo $i18n['similaritems-header']; ?></h1>
				<?php foreach($getSimilarItems as $item){ ?>
					<div class="thumbnail text-center item-stand">
						<img src="<?php echo framework::resolve('static/images/items/'.$item["IMAGE1"]); ?>" alt="<?php echo $item["NAMELONG"]; ?>"/>
						<b><?php echo substr($item["NAMESHORT"],0,15); ?></b><br/>
						<span class="badge">$<?php echo $item["PRICE"]; ?></span>
						<span class="popularity">
							<i class="glyphicon glyphicon-star orange"></i>
							<i class="glyphicon glyphicon-star orange"></i>
							<i class="glyphicon glyphicon-star"></i>
						</span>

						<div class="item-stand-caption">
							<p class="text-left"><?php echo substr($item["NAMELONG"],0,45); ?></p>
							<a href="<?php echo framework::link_to('store/item&id='.$item["ID"]); ?>" class="btn btn-primary btn-mini"><?php echo $i18n['btn-readmore']; ?></a> <!--btn-xs-->
						</div>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>