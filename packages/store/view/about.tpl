<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/menu.tpl'); ?>

<!--section: body-->
<div id="section-body" class="container">
	<div class="col-lg-12">
		<h1><?php echo $i18n['intro-header']; ?></h1>
		<pclass="wide-text"><?php echo $i18n['intro-intro']; ?></p>
	</div>

	<div class="col-lg-12">
		<h1><?php echo $i18n['about-header']; ?></h1>
	</div>

	<div class="col-lg-8 col-md-7 col-sm-6 col-xs-12">
		<p><?php echo $i18n['about-pragres-intro']; ?></p>

		<h2><?php echo $i18n['about-contact']; ?></h2>
		<address>
			<?php // <abbr title="Phone">P:</abbr> (510) 457-1656<br/> ?>
			<a href="mailto:support@fishagift.com">support@fishagift.com</a><br/><br/>

			<strong>Pragres Corp.</strong><br/>
			3250 NW 13th Terr<br/>
			Miami, Fl 33125<br/>
			<a href="http://pragres.com" target="_blank">http://pragres.com</a>
		</address>
	</div>

	<div class="col-lg-4 col-md-5 col-sm-6 hidden-xs text-right">
		<img style="border:1px solid black;" src="http://maps.googleapis.com/maps/api/staticmap?center=Miami,Fl&zoom=13&markers=Miami,Fl&size=300x300&sensor=true" alt="map"/>
	</div>
<!--
		<div class="col-lg-12">
			<h1 id="faq">Frequently Asked Questions (FAQ)</h1>
			<h2>Question #1</h2>
			<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>

			<h2>Question #2</h2>
			<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>

			<h2>Question #3</h2>
			<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>
		</div>
-->

</div>

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>