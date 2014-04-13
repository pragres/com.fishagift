<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">
			<!--section: dashboard-->
			<h1>Results of 'Clear images' maintenance's task</h1>
		</div>
	</div>

	<div class="col-lg-4">
            <p><?php echo count($result['not_found']);?> not found images.</p>
            <p><?php echo count($result['not_match']);?> unmatched images.</p>
            <p><?php echo count($result['found']);?> matched images.</p>
	</div>
        <hr/>
        <a href="<?php echo framework::link_to('admin/dashboard'); ?>">Return to dashboard</a>
	
</div>

<?php include framework::resolve("packages/admin/view/footer.tpl"); ?>