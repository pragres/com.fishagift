<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/menu.tpl'); ?>

<link href='http://fonts.googleapis.com/css?family=Monoton' rel='stylesheet' type='text/css'>

<div id="section-body" class="container">
	<div class="col-lg-12">
		<!--section: introductory text-->
		<p id="home-motto" class="text-center number-two-color">
			<?php echo $i18n['motto']; ?>
		</p>

		<!--section: button-->
		<div class="text-center">
			<a href="<?php echo framework::link_to('store/store'); ?>" class="btn btn-primary btn-lg btn-phone" style="font-size:200%; margin-top:20px;">
				<span class="glyphicon glyphicon-gift"></span> <?php echo $i18n['btn-start']; ?>
			</a>
		</div>

		<h1><?php echo $i18n['home-header']; ?></h1>
	</div>

	<!--section: explanation-->
	<div class="col-lg-4 col-md-4 col-sm-4 tutorial-step">
		<h2><span class="badge number-one">1</span> <?php echo $i18n['home-pick']; ?></h2>
		<img src="<?php echo framework::resolve('static/graphs/pick.png'); ?>" width="200" height="200" alt="Pick an item"/>
		<p><?php echo $i18n['home-pick-msg']; ?></p>
	</div>

	<div class="col-lg-4 col-md-4 col-sm-4 tutorial-step">
		<h2><span class="badge number-two">2</span> <?php echo $i18n['home-wrap']; ?></h2>
		<img src="<?php echo framework::resolve('static/graphs/wrap.png'); ?>" width="200" height="200" alt="Pick an item"/>
		<p><?php echo $i18n['home-wrap-msg']; ?></p>
	</div>

	<div class="col-lg-4 col-md-4 col-sm-4 tutorial-step">
		<h2><span class="badge number-three">3</span> <?php echo $i18n['home-send']; ?></h2>
		<img src="<?php echo framework::resolve('static/graphs/send.png'); ?>" width="200" height="200" alt="Pick an item"/>
		<p><?php echo $i18n['home-send-msg']; ?></p>
	</div>
	
	
	<!--section: button for mobile-->
	<div class="col-lg-12 center visible-xs" style="margin-top:30px;">
		<a href="<?php echo framework::link_to('store/store'); ?>" class="btn btn-primary btn-lg btn-phone" style="font-size:200%; margin-top:20px;">
			<span class="glyphicon glyphicon-gift"></span> <?php echo $i18n['btn-start']; ?>
		</a>
	</div>
</div>

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>