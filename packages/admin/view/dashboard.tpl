<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">
			<!--section: dashboard-->
			<h1>Dashboard</h1>
		</div>
	</div>

         <div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">Translation progress</div>
			<div class="panel-body">
				<table class="table table-hover">
                    <tr>
                    	<td align="right"style="width:100px" valign="top">Global</td>
                        <td>
							<div class="progress progress-striped" style="margin-bottom: 0px;" title= "The global translation progress is <?php echo $i18n_global; ?>%">
                            	<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $i18n_global; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $i18n_global; ?>%;">
                            		<span class="sr-only"><?php echo $i18n_global; ?>%</span>
                            	</div>
							</div>
						</td>
					</tr>
					<?php foreach($global_by_lang as $i18n): ?>
					<tr>
						<td align="right" valign="middle"><?php echo $i18n['LABEL']; ?></td>
						<td>
							<div class="progress progress-striped" style="margin-bottom: 0px;" title ="The translation progress to <?php echo $i18n['LABEL']; ?> is <?php echo $i18n['PERCENT']; ?>%">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $i18n['PERCENT']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $i18n['PERCENT']; ?>%;">
									<span class="sr-only"><?php echo $i18n['PERCENT']; ?>%</span>
								</div>
							</div>
						</td>
					</tr>
					<?php endforeach; ?>
					<tr>
						<td colspan="2"><i>Inventory and Lists</i></td>
					</tr>
					<?php foreach($i18n_by_lists as $listname => $i18n): ?>
					<tr>
						<td align="right"><?php echo $listname; ?></td>
						<td>
						<div class="progress progress-striped" style="margin-bottom: 0px;" title ="The <?php echo $listname; ?>'s translation progress is <?php echo $i18n['PERCENT']; ?>">
							<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?php echo $i18n['PERCENT']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $i18n['PERCENT']; ?>%;">
								<span class="sr-only"><?php echo $i18n['PERCENT']; ?>%</span>
							</div>
						</div>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">Inventory</div>
			<div class="panel-body">
				<ul>
					<li><a href="<?php echo framework::link_to("admin/items"); ?>">List of items</a> (<?php echo $count_items;?>) - <a href="<?php echo framework::link_to("admin/add_item");?>">add</a></li>
					<li><a href="<?php echo framework::link_to("admin/cards"); ?>">List of cards</a> (<?php echo $count_cards;?>) - <a href="<?php echo framework::link_to("admin/add_card");?>">add</a></li>
					<li><a href="<?php echo framework::link_to("admin/bags"); ?>">List of bags</a> (<?php echo $count_bags;?>) - <a href="<?php echo framework::link_to("admin/add_bag");?>">add</a></li>
					<li><a href="<?php echo framework::link_to("admin/papers"); ?>">List of papers</a> (<?php echo $count_papers;?>) - <a href="<?php echo framework::link_to("admin/add_paper");?>">add</a></li>
					<li><a href="<?php echo framework::link_to("admin/ornaments"); ?>">List of ornaments</a> (<?php echo $count_ornaments;?>) - <a href="<?php echo framework::link_to("admin/add_ornament");?>">add</a></li>
				</ul>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">Payment management</div>
			<div class="panel-body">
				<ul>
					<li><a target="_blank" href="https://developer.paypal.com/webapps/developer/dashboard/test">PayPal (SandBox)</a></li>
					<li><a target="_blank" href="https://manage.stripe.com">Stripe</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">Lists</div>
			<div class="panel-body">
				<ul>
					<li><a href="<?php echo framework::link_to("admin/categories"); ?>">List of categories</a> (<?php echo $count_categories;?>) - <a href="<?php echo framework::link_to("admin/add_category");?>">add</a></li>
					<li><a href="<?php echo framework::link_to("admin/cardmessages"); ?>">List of card messages</a> (<?php echo $count_cardmessages;?>) - <a href="<?php echo framework::link_to("admin/add_cardmessage");?>">add</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">Maintenance</div>
			<div class="panel-body">
				<?php if ($i_db != $i_fs) { ?>
					Not all images in the database are linked to a file in the hard disk. <br/>
					<ul>
						<li><?php echo $i_db; ?> images in the database</li>
						<li><?php echo $i_fs; ?> images in the hard disk</li>
					</ul>
					You can <a href="<?php echo framework::link_to("admin/clear_images"); ?>">clean the images</a> now
				<?php }else{ ?>
					<p>Hurra! No maintanance to do now</p>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php include framework::resolve("packages/admin/view/footer.tpl"); ?>