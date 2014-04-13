<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/menu.tpl'); ?>

<!--section: body-->
<div id="section-body" class="container">

	<!--section: items bought-->

	<div class="col-lg-12">
		<h2><?php echo $i18n['receipt-header']; ?></h2>
		<p><?php echo $i18n['receipt-help1']; ?> <b>AAA123456789</b>. <?php echo $i18n['receipt-help2']; ?></p><br/>
	</div>

	<div class="col-lg-5 col-md-5 col-sm-5 col-xm-12">
		<h1><?php echo $i18n['receipt-addressfrom-header']; ?></h1>
		<address>
			<b><p><?php echo $user['FULLNAME']; ?></p></b>
			<?php echo $order['SENDERADDRESS1']; ?><br/>
			<?php echo $order['SENDERADDRESS2']; ?><br/>
			<?php echo $order['SENDERCITY']; ?> <?php echo $order['SENDERZIPCODE']; ?>
		</address>

		<h1><?php echo $i18n['receipt-addressto-header']; ?></h1>
		<address>
			<b><p><?php echo $order['RECEIVER']; ?></p></b>
			<?php echo $order['RECEIVERADDRESS1']; ?><br/>
			<?php echo $order['RECEIVERADDRESS2']; ?><br/>
			<?php echo $order['RECEIVERCITY']; ?> <?php echo $order['RECEIVERZIPCODE']; ?>
		</address>

		<h1><?php echo $i18n['receipt-details-header']; ?></h1>
		<p style="padding-right:50px;">
			<?php echo $i18n['receipt-details-payby']; ?> <?php echo $order['PAYMENTMETHOD']['NAME']; ?>, VISA <?php echo $order['SENDER']['CREDITCARD']['CARDNUMBER']; ?>.
			<?php echo $i18n['receipt-details-sendby']; ?> USPS priority mail, two days shipping. <?php echo $order['RECEIVER']; ?>
			<?php echo $i18n['receipt-details-receiveby']; ?> <?php echo $order['DATE']; ?>
		</p>
	</div>


	<!-- section: item purchased -->

	<div class="col-lg-7 col-md-7 col-sm-7 col-xm-12">
		<h1><?php echo $i18n['receipt-breakdown-header']; ?></h1>
		<table class="table table-hover valign-middle">
			<tbody>
				<tr>
					<td class="text-center col-image"><img style="width:40px; height:40px;" src="http://fishagift.localhost/static/images/items/52a49d1f25c27-1-unnas3.jpg" alt="item"/></td>
					<td class="text-left col-category"><?php echo $i18n['payment-item']; ?></td>
					<td class="text-left"><?php echo $order['PRODUCT']['ITEMNAMELONG']; ?></td>
					<td class="text-right"><?php echo $order['PRODUCT']['ITEMPRICE']; ?></td>
				</tr>
				<tr>
					<td class="text-center col-image"><img style="width:40px; height:40px;" src="http://fishagift.localhost/static/images/papers/52a4bb120416c-1-papel%20de%20navidad.jpg" alt="paper"/></td>
					<td class="text-left col-category"><?php echo $i18n['payment-paper']; ?></td>
					<td class="text-left"><?php echo $order['PRODUCT']['PAPERNAME']; ?></td>
					<td class="text-right">$<?php echo number_format($price_paper,2); ?></td>
				</tr>
				<tr>
					<td class="text-center col-image"><img style="width:40px; height:40px;" src="http://fishagift.localhost/static/images/items/52a49d1f25c27-1-unnas3.jpg" alt="postcard"/></td>
					<td class="text-left col-category"><?php echo $i18n['payment-card']; ?></td>
					<td class="text-left"><?php echo $order['PRODUCT']['CARDTITLE']; ?></td>
					<td class="text-right">$<?php echo number_format($price_card,2); ?></td>
				</tr>
				<tr>
					<td class="text-center col-image"><img style="width:40px; height:40px;" src="http://fishagift.localhost/static/images/bags/52a4d8e20db86-1-photo%201.jpg" alt="bag"/></td>
					<td class="text-left col-category"><?php echo $i18n['payment-bag']; ?></td>
					<td class="text-left"><?php echo $order['PRODUCT']['BAGNAME']; ?></td>
					<td class="text-right">$<?php echo number_format($price_bag,2); ?></td>
				</tr>
				<?php foreach($order['PRODUCT']['ORNAMENTS'] as $po){ ?>
				<tr>
					<td class="text-center col-image"><img style="width:40px; height:40px;" src="http://fishagift.localhost/static/images/ornaments/52a4f1436977a-1-2_2.JPG" alt="ornament"/></td>
					<td class="text-left col-category"><?php echo $i18n['payment-ornament']; ?></td>
					<td class="text-left"><?php echo $po['ORNAMENT']; ?></td>
					<td class="text-right">$<?php echo number_format($price_ornament,2); ?></td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3"><?php echo $i18n['payment-tax']; ?></th>
					<th class="text-right">$<span id="taxes">1.20</span></th>
				</tr>
				<tr>
					<th colspan="3"><?php echo $i18n['payment-shipping']; ?></th>
					<th class="text-right">$<span id="shipping">5.25</span></th>
				</tr>
				<tr>
					<th colspan="3"><?php echo $i18n['payment-total']; ?></th>
					<th class="text-right">$<span class="payment-total">15.20</span></th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>