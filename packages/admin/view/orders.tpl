<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">
			<!--section: Open orders-->
			<h1><?php echo $status; ?> orders</h1>
			Filter by status: 
			<a href = "<?php echo framework::link_to("admin/orders"); ?>&status=Pending">Pending</a> | 
			<a href = "<?php echo framework::link_to("admin/orders"); ?>&status=Cancelled">Cancelled</a> | 
			<a href = "<?php echo framework::link_to("admin/orders"); ?>&status=Delivered">Delivered</a>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Date</th>
						<th>Tracking number</th>
						<th>Confirmation number</th>
						<th>Sender</th>
						<th>Change estatus to</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($orders as $item){ ?>
						<?php $style = ''; if ($highlight == $item['TRANSACTION']) $style= 'style="background: #80e181;"'; ?>
						<tr>
							<td <?php echo $style;?>><?php echo $item["DATE"]; ?></td>
							<td <?php echo $style;?>><?php echo $item["TRACKING"]; ?></td>
							<td <?php echo $style;?>><?php echo $item["CONFIRMATIONNUMBER"]; ?></td>
							<td <?php echo $style;?>><?php echo $item["SENDER"]; ?></td>
							<td class="text-center">
								<?php if ($status !='Pending'): ?>
								<a class="btn btn-default btn-mini" href="<?php echo framework::link_to("admin/set_order_status"); ?>&status=Pending&transaction=<?php echo $item['TRANSACTION']; ?>">Pending</a>
								<?php endif; ?>
								
								<!--
								<?php if ($status !='Delivered'): ?>
								<a class="btn btn-default btn-mini" href="<?php echo framework::link_to("admin/set_order_status"); ?>&status=Delivered&transaction=<?php echo $item['TRANSACTION']; ?>">Delivered</a>
								<?php endif; ?>
								-->
								
								<?php if ($status !='Cancelled'): ?>
								<a class="btn btn-default btn-mini" href="<?php echo framework::link_to("admin/set_order_status"); ?>&status=Cancelled&transaction=<?php echo $item['TRANSACTION']; ?>">Cancelled</a>
								<?php endif; ?>
							</td>
							<td class="text-center">
							<a class="btn btn-default btn-mini" href="<?php echo framework::link_to("admin/order_details"); ?>&transaction=<?php echo $item['TRANSACTION']; ?>">Details</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>