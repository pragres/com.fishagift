<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<div class="container">
	<?php include framework::resolve("packages/admin/view/admin_menu.tpl"); ?>

	<div class="page-header">
		<i>Fish a Gift - Administration</i><br/>
		<h1><?php if (isset($title)) echo $title; else echo "Administration"; ?></h1>
	</div>