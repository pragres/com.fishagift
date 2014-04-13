<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/menu.tpl'); ?>

<!--section: body-->
<div id="section-body" class="container">
	<!--section: items bought-->
	<div class="col-lg-12">
		<h1><?php echo $i18n['fished-header']; ?></h1>
		<p><?php echo $i18n['fished-help']; ?></p><br/>

		<table class="table table-hover">
			<thead>
				<tr>
					<th class="text-center"><?php echo $i18n['fished-date']; ?></th>
					<th class="text-center"><?php echo $i18n['fished-item']; ?></th>
					<th class="text-center"><?php echo $i18n['fished-confirmation']; ?></th>
					<th class="text-center"><?php echo $i18n['fished-price']; ?></th>
					<th class="text-center"><?php echo $i18n['fished-tracking']; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($orders as $order) {?>
				<tr>
					<td><?php echo $order['DATE']; ?></td>
					<td><a href="<?php echo framework::link_to("store/orderdetails") . "&order=".$order['TRANSACTION']; ?>" title="View inside"><?php echo $order['PRODUCT']['ITEMNAMELONG']; ?></a></td>
					<td class="text-center"><?php echo $order['CONFIRMATIONNUMBER']; ?></td>
					<td class="text-right"><?php echo $order['PRODUCT']['PRICE'] ?></td>
					<td class="text-center"><a href="#" title="Track package"><?php echo $order['TRACKING']; ?></a></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>