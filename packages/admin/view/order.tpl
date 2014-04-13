<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>
<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">
			<h1>Order details</h1>
			
			<fieldset>
			<legend>Order</legend>
			<form class="form-horizontal" role="form" action="<?php echo framework::link_to("admin/order_details"); if (isset($transaction)) echo '&transaction='.$transaction; if (!empty($current_lang)) echo '&lang='.$current_lang;?>" method="post">
			
			Transaction: <b><?php echo $order['TRANSACTION']; ?></b><br/>
			Date: <b><?php echo $order['DATE']; ?></b><br/>
			
			Tracking number: <b><input class="form-control" style="width:100px;" name="trackingNumber" value ="<?php echo $order['TRACKING']; ?>"/></b> 
			
			Status: <b><?php echo $order['STATUS']; ?></b><br/>
			Sender: <b><?php echo $order['SENDER']['FULLNAME']; ?> <a href="mailto:">(<?php echo $order['SENDER']['EMAIL']; ?>)</a></b><br/>
				
			<hr/>
			Receiver: <strong><?php echo $order['RECEIVER']; ?></strong><br/>
			Address of receiver: <strong><?php echo $order['RECEIVERADDRESS1']; ?></strong>&nbsp;<strong><?php echo $order['RECEIVERADDRESS2']; ?></strong><br/>
			</fieldset>
			
			<button rel="button" class="btn btn-primary btn-lg">Save</button>
			</form><br/>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>