<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/menu.tpl'); ?>

<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script type="text/javascript">
	/**
	 * Updates the shipping price in the payments breakdown and in the 
	 * session structure when somebody changes the shipping method 
	 */
	function refreshShippingPrice(newShippingPrice, shippingMethod, carrier){
		// add new price to the session varible by ajax
		$.ajax({
			url: "<?php echo framework::link_to('store/updateShippingPriceInSession_ajax', false); ?>",
			data: {"price":newShippingPrice, "shippingMethod":shippingMethod, "carrier":carrier},
			async: false
		}).fail(function() {
			alert("We apologize but something failed. The page has to be reloaded.");
			location.reload();
		});

		// calculate total price
		var basePrice = <?php echo $total ?> * 1;
		var newTotalPrice = basePrice + newShippingPrice * 1;

		// add new price to shipping and handeling
		$('#shipping').html(newShippingPrice.toFixed(2));

		// add new price to the button place order
		$('.payment-total').html(newTotalPrice.toFixed(2));
	}

	/**
	 * Changes the payment method when the user clicks the payment tabs
	 */
	function changePaymentMethodTab(id,type,obj){
		// displaying the cliked tab
		$('.paymentmethod').slideUp();
		$('#'+id).slideDown();

		// setting the value of the hidden input
		$('input#paymentmethod').val(type);

		// showing the tab as active
		$('ul#paymentmethod-tabs').find('li').removeClass('active');
		$(obj).addClass('active');

		// changing the action to submit to the right place
		switch(type){
			case "CC" :{
				$('#formAction').val('payByCreditCard');
				$('input.required').attr('required','required');
				break;
			}
			case "PP" :{
				$('#formAction').val('payByPayPal');
				$('input.required').removeAttr('required');
				$('input.required').val(''); // @TODO workaround for Chrome. Cannot submit hidden, required fields
				break;
			}
		}
	}

	// this identifies your website in the createToken call below
	Stripe.setPublishableKey('<?php echo $stripe_publishable_key; ?>');

	function stripeResponseHandler(status, response) {
		if (response.error) {
			// re-enable the submit button
			$('#btn-placeorder').removeAttr("disabled");
			// show the errors on the form
			$("#payment-errors").html(response.error.message).show();
		} else {
			var form = $("#section-send");
			// token contains id, last4, and card type
			var token = response['id'];
			// insert the token into the form so it gets submitted to the server
			form.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
			// and submit
			form.get(0).submit();
		}
	}

	$(document).ready(function() {
		$("#section-send").submit(function(event) {
			// if the form is invalid, scroll tp the element and do not submit
			if(!$('#section-send').ht5ifv('valid')) {
				var error = $('.ht5ifv-show-invalid').first();
				$('html,body').animate({scrollTop: error.offset().top - 150});
				return;
			}

			// only request token when paying by credit card
			var formAction = $('#formAction').val();
			if(formAction!="payByCreditCard") return;

			// disable the submit button to prevent repeated clicks
			$('#btn-placeorder').attr("disabled", "disabled");

			// createToken returns immediately - the supplied callback submits the form if there are no errors
			Stripe.createToken({
				number: $('#ccNumber').val(),
				cvc: $('#ccSecurityCode').val(),
				exp_month: $('#ccExpirationMonth').val(),
				exp_year: $('#ccExpirationYear').val()
			}, stripeResponseHandler);
			return false; // submit from callback
		});

		// popover for the CVV label
		$(document).ready(function(){
			var img = '<img width="400px;" src="<?php echo framework::resolve('static/graphs/securitycode.png'); ?>" alt="Visa, Mastercard, Discovery: 3 digits on the back. Amex: 4 digits on the front">';
			$('#ccSecurityCode-label').popover({
				placement: 'top',
				trigger: 'hover',
				title: '<?php echo $i18n['creditcard-securitycode']; ?>',
				html: true,
				content: img
			});
		});
	});
</script>

<div id="section-body" class="container">
	<!--section: send-->
	<form id="section-send" class="form-horizontal" role="form" action="router.php" method="POST">
		<input name="package" type="hidden" value="store">
		<input type="hidden" id="formAction" name="page" value="payByCreditCard"/>

		<!--subsection: from-->
		<div class="col-lg-12">
			<h1><?php echo $i18n['from-header']; ?></h1>
		</div>
		<div class="row">
			<div class="col-lg-7 col-md-7 col-sm-7 col-xm-12">
				<div class="form-group">
					<label for="fromFirstName" class="col-lg-3 col-md-3 col-sm-3 control-label"><?php echo $i18n['info-name']; ?></label>
					<div class="col-lg-9 col-md-9 col-sm-9">
						<input id="fromFirstName" name="fromName" type="text" class="form-control" placeholder="<?php echo $i18n['info-name']; ?>" value="<?php echo $fromName; ?>" required/>
					</div>
				</div>
				<div class="form-group">
					<label for="fromAddress1" class="col-lg-3 col-md-3 col-sm-3 control-label"><nobr><?php echo $i18n['address-address']; ?> 1</nobr></label>
					<div class="col-lg-9 col-md-9 col-sm-9">
						<input id="fromAddress1" name="fromAddress1" class="form-control" type="text" placeholder="<?php echo $i18n['address-address']; ?> 1"  value="<?php echo $fromAddress1; ?>" required/>
					</div>
				</div>
				<div class="form-group">
					<label for="fromAddress2" class="col-lg-3 col-md-3 col-sm-3 control-label"><nobr><?php echo $i18n['address-address']; ?> 2</nobr></label>
					<div class="col-lg-9 col-md-9 col-sm-9">
						<input id="fromAddress2" name="fromAddress2" class="form-control" type="text" placeholder="<?php echo $i18n['address-address']; ?> 2"  value="<?php echo $fromAddress2; ?>" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-3 col-lg-offset-3 col-md-3 col-md-offset-3 col-sm-5">
						<label for="fromState" class="control-label visible-xs"><?php echo $i18n['address-state']; ?></label>
						<select id="fromState" name="fromState" class="form-control" required>
							<option value=""><?php echo $i18n['address-state']; ?></option>
							<?php foreach ($states as $state) { ?>
								<option value="<?php echo $state['code']; ?>" <?php if ($fromState == $state['code']) echo 'selected';?>><?php echo $state['name']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4">
						<label for="fromCity" class="control-label visible-xs space-top-20-xs"><?php echo $i18n['address-city']; ?></label>
						<input id="fromCity" name="fromCity" type="text" class="form-control" placeholder="<?php echo $i18n['address-city']; ?>"  value="<?php echo $fromCity; ?>" required/>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3">
						<label for="fromZipcode" class="control-label visible-xs space-top-20-xs"><?php echo $i18n['address-zipcode']; ?></label>
						<input id="fromZipcode" name="fromZipcode" maxlength="5" type="text" class="form-control" placeholder="<?php echo $i18n['address-zipcode']; ?>" required pattern="[0-9]{5}" title="<?php echo $i18n['address-zipcode-title']; ?>"  value="<?php echo $fromZipcode; ?>" />
					</div>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 hidden-xs">
				<p><?php echo $i18n['from-help']; ?></p>
			</div>
		</div>

		<!--subsection: to-->
		<div class="row">
			<div class="col-lg-12">
				<h1><?php echo $i18n['to-header']; ?></h1>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xm-12">
				<div class="form-group">
					<label for="toFirstName" class="col-lg-3 col-md-3 col-sm-3 control-label"><?php echo $i18n['info-name']; ?></label>
					<div class="col-lg-9 col-md-9 col-sm-9">
						<input id="toFirstName" name="toFirstName" type="text" class="form-control" placeholder="<?php echo $i18n['info-name']; ?>" value="<?php echo $toFirstName; ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label for="toAddress1" class="col-lg-3 col-md-3 col-sm-3 control-label"><nobr><?php echo $i18n['address-address']; ?> 1</nobr></label>
					<div class="col-lg-9 col-md-9 col-sm-9">
						<input id="toAddress1" name="toAddress1" class="form-control" type="text" placeholder="<?php echo $i18n['address-address']; ?> 1" value="<?php echo $toAddress1; ?>" required />
					</div>
				</div>
				<div class="form-group">
					<label for="toAddress2" class="col-lg-3 col-md-3 col-sm-3 control-label"><nobr><?php echo $i18n['address-address']; ?> 2</nobr></label>
					<div class="col-lg-9 col-md-9 col-sm-9">
						<input id="toAddress2" name="toAddress2" class="form-control" type="text" placeholder="<?php echo $i18n['address-address']; ?> 2" value="<?php echo $toAddress2; ?>" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-3 col-lg-offset-3 col-md-3 col-md-offset-3 col-sm-5">
						<label for="toState" class="control-label visible-xs"><?php echo $i18n['address-state']; ?></label>
						<select id="toState" name="toState" class="form-control" required>
							<option value=""><?php echo $i18n['address-state']; ?></option>
							<?php foreach ($states as $state) { ?>
								<option value="<?php echo $state['code']; ?>"><?php echo $state['name']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4">
						<label for="toCity" class="control-label visible-xs space-top-20-xs"><?php echo $i18n['address-city']; ?></label>
						<input id="toCity" name="toCity" type="text" class="form-control" placeholder="<?php echo $i18n['address-city']; ?>" value="<?php echo $toCity; ?>" required />
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3">
						<label for="toZipcode" class="control-label visible-xs space-top-20-xs"><?php echo $i18n['address-zipcode']; ?></label>
						<input id="toZipcode" name="toZipcode" maxlength="5" type="text" class="form-control" placeholder="<?php echo $i18n['address-zipcode']; ?>" required pattern="[0-9]{5}" title="<?php echo $i18n['address-zipcode-title']; ?>" value="<?php echo $toZipcode; ?>" />
					</div>
				</div>
			</div>
			
			<div class="col-lg-5 col-md-5 col-sm-5 hidden-xs">
				<p><?php echo $i18n['to-help']; ?></p>
			</div>
		</div>		

		<!--subsection: shipping method-->
		<div class="row">
			<div class="col-lg-12">
				<h1><?php echo $i18n['shipping-header']; ?></h1>
			</div>
			<div id="shipping-method" class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<?php foreach($shipping_prices as $method){ ?>
					<div class="radio" onclick="refreshShippingPrice(<?php echo $method->price; ?>, '<?php echo $method->name; ?>',  '<?php echo $method->carrier; ?>');">
						<label>
							<input type="radio" name="shipping" class="value" required />
							<span class="details">
								<span class="speed"><?php echo $i18n[$method->speed->speed]; ?>: </span>
								<span class="green">$<span class="price"><?php echo number_format ($method->price, 2); ?></span></span>
							</span>
							<p class="delivered"><?php echo $i18n['shipping-receivedate'] . " " . $method->speed->predictExpectedDelivery(); ?></p>
						</label>
					</div>				
				<?php } ?>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 hidden-xs">
				<p><?php echo $i18n['shipping-help']; ?></p>
			</div>
		</div>

		<!--subsection: shopping summary-->
		<div class="row">
			<div class="col-lg-12">
				<h1><?php echo $i18n['payment-header']; ?></h1>
			</div>
			<div class="col-lg-12">
				<table class="table table-hover valign-middle">
					<tbody>
						<?php if($shopping_cart_item != "") { ?>
						<tr>
							<td class="text-center col-image"><img style="width:40px; height:40px;" src="http://static.fishagift.com/images/items/<?php echo $shopping_cart_item['IMAGE1']; ?>" alt="item"/></td>
							<td class="text-left"><?php echo $shopping_cart_item['NAMELONG']; ?></td>
							<td class="text-right">$<?php echo number_format($shopping_cart_item['PRICE'],2); ?></td>
						</tr>
						<?php } ?>

						<?php if($shopping_cart_paper != "") { ?>
						<tr>
							<td class="text-center col-image"><img style="width:40px; height:40px;" src="http://static.fishagift.com/images/papers/<?php echo $shopping_cart_paper['IMAGE']; ?>" alt="paper"/></td>
							<td class="text-left"><?php echo $shopping_cart_paper['NAME']; ?></td>
							<td class="text-right">$<?php echo number_format($price_paper,2); ?></td>
						</tr>
						<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="2"><?php echo $i18n['payment-tax']; ?></th>
							<th class="text-right">$<span id="taxes"><?php echo number_format($tax,2); ?></span></th>
						</tr>
						<tr>
							<th colspan="2"><?php echo $i18n['payment-shipping']; ?></th>
							<th class="text-right">$<span id="shipping"><?php echo number_format($shipping,2); ?></span></th>
						</tr>
						<tr>
							<th colspan="2"><?php echo $i18n['payment-total']; ?></th>
							<th class="text-right">$<span class="payment-total"><?php echo number_format($total,2); ?></span></th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

		<!--subsection: payment method-->
		<div class="row">
			<div class="col-lg-12">
				<h1><?php echo $i18n['paymentmethod-header']; ?></h1>
				<div id="payment-errors" class="alert alert-danger" style="display:none;"></div>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-8 col-xs-12">
				<input type="hidden" id="paymentmethod" name="paymentmethod" value="CC"/>

				<!--sub-subsection: tabs-->
				<ul id="paymentmethod-tabs" class="nav nav-tabs" style="margin-bottom:20px;">
					<li onclick="changePaymentMethodTab('paymentmethod-credit','CC',this);" class="active"><a href="#" onclick="return false;"><img src="<?php echo framework::resolve('static/graphs/payment/creditcard.png'); ?>" width="35" alt="CC" style="margin-right:10px;"/><?php echo $i18n['paymentmethod-tab-creditcard']; ?></a></li>
					<li onclick="changePaymentMethodTab('paymentmethod-paypal','PP',this);"><a href="#" onclick="return false;"><img src="<?php echo framework::resolve('static/graphs/payment/paypal.png'); ?>" width="35" alt="PP" style="margin-right:10px;" /><?php echo $i18n['paymentmethod-tab-paypal']; ?></a></li>
				</ul>

				<!--sub-subsection: credit card-->
				<div id="paymentmethod-credit" class="paymentmethod">
					<div class="form-group">
						<label for="ccName" class="col-lg-3 col-md-3 col-sm-3 control-label"><?php echo $i18n['creditcard-name']; ?></label>
						<div class="col-lg-9 col-md-9 col-sm-9">
							<input id="ccName" name="ccName" type="text" class="form-control required" placeholder="<?php echo $i18n['creditcard-name']; ?>" value="<?php echo $ccName; ?>" required/>
						</div>
					</div>
					<div class="form-group">
						<label for="ccNumber" class="col-lg-3 col-md-3 col-sm-3 control-label"><?php echo $i18n['creditcard-number']; ?></label>
						<div class="col-lg-9 col-md-9 col-sm-9">
							<input id="ccNumber" name="ccNumber" type="text" class="form-control required" placeholder="<?php echo $i18n['creditcard-number']; ?>" value="<?php echo $ccNumber; ?>" required pattern="[0-9]{16}" title="<?php echo $i18n['creditcard-number-title']; ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="ccExpirationMonth" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 control-label"><?php echo $i18n['creditcard-expdate']; ?></label>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 nospace-right">
							<select id="ccExpirationMonth" name="ccExpirationMonth" class="form-control required" title="<?php echo $i18n['creditcard-expdate-month-title']; ?>">
								
								<?php if(intval($ccExpirationMonth) == 0){?>
									<option value="">MM</option>
								<?php } ?>
								
								
								<?php 
									for($i=1; $i<13; $i++) {
										echo "<option value='$i'";
										if ($i == intval($ccExpirationMonth)) echo " selected ";
										echo ">$i</option>"; 
									}
								?>
							</select>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
							<select id="ccExpirationYear" name="ccExpirationYear" type="text" class="form-control required" title="<?php echo $i18n['creditcard-expdate-year-title']; ?>">
								
								<?php if(intval($ccExpirationYear) == 0){?>
									<option value=""><?php echo $i18n['cc-yyyy']; ?></option>
								<?php } ?>
								
								<?php 
									for($i=date("Y"); $i<date("Y")+10; $i++) {
										echo "<option value='$i'";
										if (intval($ccExpirationYear) == $i) echo " selected ";
										echo ">$i</option>"; 
									}
								?>
							</select>
						</div>
						<label id="ccSecurityCode-label" rel="tooltip" for="ccSecurityCode" class="col-lg-2 col-md-2 col-sm-2 col-xs-6 space-top-20-xs cvv popit control-label">CVV <span style="color:#498FCC;" class="glyphicon glyphicon-question-sign"></span></label>
						<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6 space-top-20-xs">
							<input id="ccSecurityCode" name="ccSecurityCode" type="text" class="form-control required nospace-right" value="<?php echo $ccSecurityCode; ?>" required pattern="[0-9]{3}" title="<?php echo $i18n['creditcard-securitycode-title']; ?>"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3">
							<div class="checkbox">
								<label class="control-label">
									<input name="ccSaveCreditCard" type="checkbox" checked="checked" />
									<?php echo $i18n['creditcard-saveprofile']; ?>
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-3 col-xs-12">
							<button id="btn-placeorder" type="submit" class="btn btn-primary btn-lg" style="width:300px; height:70px; font-size:25px;">
								<span class="glyphicon glyphicon-gift"></span>
								<span><?php echo $i18n['btn-placeorder']; ?></span>
								<p class="text-center" style="font-size:10px; color:white;">
									<?php echo $i18n['btn-placeorder-msg1']; ?>
									<strong>$<span class="payment-total"><?php echo number_format($total,2); ?></span></strong>
									<?php echo $i18n['btn-placeorder-msg2']; ?>
								</p>
							</button>
						</div>
					</div>
				</div>

				<!--sub-subsection: paypal-->
				<div id="paymentmethod-paypal" class="paymentmethod text-center" style="display:none;">
					<p style="margin:0px 20px 20px 20px;"><?php echo $i18n['paypal-help']; ?></p>
	
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
						<!-- Identify your business so that you can collect the payments. -->
						<input type="hidden" name="business" value="sales@fishagift.com">
						<!-- Specify a Buy Now button. -->
						<input type="hidden" name="cmd" value="_xclick">
						<!-- Specify details about the item that buyers will purchase. -->
						<input type="hidden" name="item_name" value="Hot Sauce-12oz Bottle">
						<input type="hidden" name="amount" value="5.95">
						<input type="hidden" name="tax" value="0.12">
						<input type="hidden" name="shipping" value="11.50">
						<input type="hidden" name="currency_code" value="USD">
						<!-- Display the payment button. -->
						<input type="image" name="submit" width="250" src="<?php echo framework::resolve('static/graphs/paypal.png'); ?>" alt="PayPal - The safer, easier way to pay online"/>
					</form>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
				<p class="hidden-xs"><?php echo $i18n['creditcard-help']; ?></p>
				<div class="text-center">
					<!-- Begin Official PayPal Seal -->
					<a href="https://www.paypal.com/us/verified/pal=salvi.pascual@pragres.com" target="_blank"><img src="<?php echo framework::resolve('static/graphs/verification_seal.png'); ?>" border="0" alt="Official PayPal Seal"></a>
					<!-- End Official PayPal Seal -->
				</div>
			</div>
		</div>
	</form>
</div>

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>