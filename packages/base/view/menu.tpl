<?php 
	$lang = framework::session_get('language');
	$package = framework::getValue('package');
	include_once framework::resolve("packages/base/i18n/$lang/menu.php");
?>

<!--section: menu-->
<div id="menu" class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button class="navbar-toggle" data-toggle="collapse" data-target="#collapsable-menu">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<a class="navbar-brand" href="<?php echo framework::link_to('store/home'); ?>">
				<img src="<?php echo framework::resolve('static/graphs/logo.png'); ?>" alt="logo" style="width:22px;"/>
				<?php echo $i18n['logo']; ?>
			</a>
		</div>

		<div id="collapsable-menu" class="collapse navbar-collapse">
			<!--subsection: login/registration and user menu-->
			<ul class="nav navbar-nav navbar-left">
				<li><a href="<?php echo framework::link_to('store/home'); ?>"><span class="glyphicon glyphicon-home"></span> <?php echo $i18n['home']; ?></a></li>
				<li><a href="<?php echo framework::link_to('store/store'); ?>"><span class="glyphicon glyphicon-gift"></span> Store</a></li>
				<li><a href="<?php echo framework::link_to('store/about'); ?>"><span class="glyphicon glyphicon-question-sign"></span> <?php echo $i18n['about']; ?></a></li>
			</ul>

			<!--subsection:  login/registration and language-->
			<ul class="nav navbar-nav navbar-right" style="margin-right:10px;">
				<?php if(isset($isSessionStarted) && $isSessionStarted) { ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $user['FULLNAME']=="" ? $user['USER'] : $user['FULLNAME']; ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo framework::link_to('store/profile'); ?>"><span class="glyphicon glyphicon-wrench"></span> <?php echo $i18n['profile']; ?></a></li>
							<li><a href="<?php echo framework::link_to('store/fished'); ?>"><span class="glyphicon glyphicon-gift"></span> <?php echo $i18n['fished']; ?></a></li>
							<li><a href="<?php echo framework::link_to('base/logout_submit'); ?>"><span class="glyphicon glyphicon-remove-circle"></span> <?php echo $i18n['logout']; ?></a></li>
						</ul>
					</li>
				<?php } else { ?>
					<li><a href="<?php echo framework::link_to('base/login'); ?>"><?php echo $i18n['login']; ?></a></li>
					<li><a href="<?php echo framework::link_to('base/login'); ?>"><?php echo $i18n['register']; ?></a></li>
				<?php } ?>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?php echo framework::resolve("static/graphs/lang/$lang.png"); ?>" alt="<?php echo $lang; ?>" style="margin-right:5px;"/>
						<?php echo $i18n['language']; ?><b class="caret"></b>
					</a>
					<ul class="dropdown-menu" style="min-width: 110px;">
						<?php foreach ($languages as $langx) { ?>
						<li>
	                    	<a href="<?php echo framework::link_to('base/changeLang_submit', false)."&returnTo=$package/$page&language={$langx['CODE']}&".framework::getCurrentUrlQuery(); ?>">
	                        <img src="<?php echo framework::resolve('static/graphs/lang/'.$langx['CODE'].'.png'); ?>" alt="<?php echo $langx['COUNTRY']; ?>"/> <?php echo $i18n[strtolower($langx['NAME'])]; ?></a>
						</li>
	                    <?php } ?>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
