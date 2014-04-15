<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/menu.tpl'); ?>

<!--section: body-->
<div id="section-body" class="container">

	<!--section: items bought-->

	<div class="col-lg-12">
		<h2><?php echo $i18n['receipt-header']; ?></h2>
	</div>

	<div class="col-lg-5 col-md-5 col-sm-5 col-xm-12">
		<h1><?php echo $i18n['receipt-addressto-header']; ?></h1>
		<address>
			<p><b><?php echo $order['RECEIVER']; ?></b></p>
			<?php echo $order['RECEIVERADDRESS1']; ?><br/>
			<?php echo $order['RECEIVERADDRESS2'] ? $order['RECEIVERADDRESS2']."<br/>" : ""; ?>
			<?php echo $order['RECEIVERCITY']; ?> <?php echo $order['RECEIVERZIPCODE']; ?>
		</address>

		<h1><?php echo $i18n['receipt-details-header']; ?></h1>
		<p style="padding-right:50px;">
			<?php echo $i18n['receipt-details-payby']; ?> <?php echo $order['PAYMENTMETHOD']['NAME']; ?>, <?php echo $order['SENDER']['CARDTYPE']; ?> <?php echo $ccNumber; ?>.
			<?php echo $i18n['receipt-details-sendby']; ?> USPS priority mail, two days shipping. <?php echo $order['RECEIVER']; ?>
			<?php echo $i18n['receipt-details-receiveby']; ?> <?php echo $arrivalDate; ?>
		</p>
	</div>

	<!-- section: item purchased -->

	<div class="col-lg-7 col-md-7 col-sm-7 col-xm-12">
		<h1><?php echo $i18n['receipt-breakdown-header']; ?></h1>
		<table class="table table-hover valign-middle">
			<tbody>
				<tr>
					<td class="text-center col-image"><img style="width:40px; height:40px;" src="<?php echo framework::resolve("static/images/items/{$order['PRODUCT']['ITEMIMAGE']}"); ?>" alt="item"/></td>
					<td class="text-left"><?php echo $order['PRODUCT']['ITEMNAMELONG']; ?></td>
					<td class="text-right"><?php echo number_format($order['PRODUCT']['ITEMPRICE'],2); ?></td>
				</tr>
				<tr>
					<td class="text-center col-image"><img style="width:40px; height:40px;" src="<?php echo framework::resolve("static/images/papers/{$order['PRODUCT']['PAPERIMAGE']}"); ?>" alt="paper"/></td>
					<td class="text-left"><?php echo $order['PRODUCT']['PAPERNAME']; ?></td>
					<td class="text-right">$<?php echo number_format($price_paper,2); ?></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"><?php echo $i18n['payment-tax']; ?></td>
					<td class="text-right">$<span id="taxes"><?php echo number_format($order['PRODUCT']['TAX'],2); ?></span></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $i18n['payment-shipping']; ?></td>
					<td class="text-right">$<span id="shipping"><?php echo $order['PRODUCT']['SHIPPINGPRICE']; ?></span></td>
				</tr>
				<tr>
					<td colspan="2"><?php echo $i18n['payment-total']; ?></td>
					<td class="text-right"><b>$<span class="payment-total"><?php echo number_format($order['PRODUCT']['PRICE'],2); ?></span></b></td>
				</tr>
			</tfoot>
		</table>
	</div>

	<div class="text-center col-lg-12 col-md-12 col-sm-12 col-xm-12" style="margin-top:40px;">
		<a href="<?php echo framework::link_to('store/fished'); ?>" class="btn btn-success btn-phone btn-lg">
			<span class="glyphicon glyphicon-arrow-left"></span> <?php echo $i18n['back']; ?> 
		</a>
	</div>

</div>

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>