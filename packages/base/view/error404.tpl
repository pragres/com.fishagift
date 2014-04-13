<?php
	// creating a custom PHP error
	trigger_error("404 - File not found"); 
	// loading internacionalization
	$lang = framework::session_get('language');
	include_once framework::resolve("packages/base/i18n/$lang/error404.php");
	// including header
	include_once framework::resolve('packages/base/view/header.tpl');
?>

<!--section: body-->
<div id="section-body" class="container" style="padding-right: 30px;">
	<div class="row">
		<div class="col-lg-7">
			<span class="pull-left" style="font-size: 202px; color:#FF4040; text-shadow: 1px 1px 1px #000, 3px 3px 5px black; font-family: Tahoma; margin-top:-30px;">404</span>
			<p class="text-left" style="font-size: 32px; color:#27959A; font-family: Tahoma; margin:50px 0px 0px 370px;"><?php echo $i18n['explanation']; ?></p>
		</div>

		<div class="col-lg-5" style="padding-top: 45px;">
			<p style="font-weight: bold;"><?php echo $i18n['introduction']; ?></p>
			<p><?php echo $i18n['badNews']; ?></p>
			<p><?php echo $i18n['goodNews']; ?></p>    
		</div>
	</div>

	<div class="row">
		<div class="col-lg-8 text-center">
			<a href="javascript:history.back();" style="margin-right: 5px;" class="btn btn-default"><span class="glyphicon glyphicon-share-alt"></span> <?php echo $i18n['btnGoBack']; ?></a>
			<a href="<?php echo framework::link_to('store/store'); ?>" class="btn btn-success"><span class="glyphicon glyphicon-gift"></span> <?php echo $i18n['btnNewPresent']; ?></a>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>