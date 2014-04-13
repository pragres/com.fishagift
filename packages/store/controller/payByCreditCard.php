<?php

// redirect to the login page if session is not started
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/email/model/Email.php');

$isSessionStarted = Security::isSessionStarted();

if (! $isSessionStarted)
	header("Location: " . framework::link_to('store/home'));

$user = Security::getCurrentUser();

$languages = Security::getLanguages();
$lang = framework::session_get('language');
$payment_method = 'CC'; // TODO: retrieve it from DB?

include_once framework::resolve('packages/store/model/ShoppingCart.php');
include_once framework::resolve('packages/admin/model/Administration.php');

$email = $user['EMAIL'];

$ccSaveCreditCard = false;

foreach ( $_POST as $key => $value )
	$$key = $value;

if (isset($ccSaveCreditCard))
	$ccSaveCreditCard = true;
	/*
 * // save name and last name to the profile $fromFirstName = framework::getValue('fromFirstName'); $fromLastName = framework::getValue('fromLastName'); Administration::setNameToProfile($email, $fromFirstName, $fromLastName);
 */
	// save address_from to the profile
	/*
 * $fromAddress1 = framework::getValue('fromAddress1'); $fromAddress2 = framework::getValue('fromAddress2'); $fromCity = framework::getValue('fromCity'); $fromCountry = framework::getValue('fromCountry'); $fromZipcode = framework::getValue('fromZipcode'); Administration::setFromAddress($email, $fromAddress1, $fromAddress2, $fromCity, $fromCountry, $fromZipcode);
 */
	
// obtain last four digits of the credit card to show on the receipt
	/*
 * $paymentMethod = "CC"; $ccNumberLastFourDigits = "XXXX-XXXX-XXXX-" . substr($ccNumber, - 4);
 */
	// obtain address_to to create order
	/*
 * $toFirstName = framework::getValue('toFirstName'); $toLastName = framework::getValue('toLastName'); $toAddress1 = framework::getValue('toAddress1'); $toAddress2 = framework::getValue('toAddress2'); $toCity = framework::getValue('toCity'); $toCountry = framework::getValue('toCountry'); $toZipcode = framework::getValue('toZipcode');
 */
	// gather total price to charge

framework::log("$email pay by Credit Card");

$getShoppingCart = ShoppingCart::getShoppingCart();
$price = number_format($getShoppingCart['price'] * 1, 2);
$tax = floor((Security::getTaxByPrice($price) * 100)) / 100;
$shipping = number_format($getShoppingCart['shipping']['price'], 2);
$total = number_format($price + $tax + $shipping, 2) * 100;

framework::log("$email pay PRICE = $price TAX = $tax SHIPPING = $shipping TOTAL = $total");

// total in cents (int) @TODO make this formula more accurated, we dond wanna lost cents

// $total = 2054; // total in cents (int)
// submit the payment

require 'libs/Stripe/config.php';
try {
	if (! isset($_POST['stripeToken'])) {
		Security::logAndAlertError("The Stripe Token was not generated correctly", "HIGH");
		throw new Exception("The Stripe Token was not generated correctly");
	}
	Stripe_Charge::create(array(
			"amount" => $total, // amount in cents (int)
			"currency" => "usd",
			"card" => $_POST['stripeToken']
	));
	$success = 'Your payment was successful.';
} catch ( Exception $e ) {
	Security::logAndAlertError($e->getMessage(), "HIGH");
	die($e->getMessage());
}

// creating work order
$order = array(
		"TRACKING" => 0,
		"SENDER" => $user['EMAIL'],
		"SENDERADDRESS1" => $fromAddress1,
		"SENDERADDRESS2" => $fromAddress2,
		"SENDERCITY" => $fromCity,
		"SENDERZIPCODE" => $fromZipcode,
		"RECEIVER" => $toFirstName,
		"RECEIVERADDRESS1" => $toAddress1,
		"RECEIVERADDRESS2" => $toAddress2,
		"RECEIVERCITY" => $toCity,
		"RECEIVERZIPCODE" => $toZipcode,
		"SHOPPINGCART" => ShoppingCart::getShoppingCart(true),
		"PAYMENTMETHOD" => $payment_method,
		"CONFIRMATIONNUMBER" => strtoupper(uniqid()),
		"TAX" => $tax,
		"SHIPPINGPRICE" => $shipping,
		"PRICE" => number_format((float) ((float) $total / (float) 100), 2)
);

Security::saveProfile(array(
		"EMAIL" => $user['EMAIL'],
		"FULLNAME" => $fromName,
		"LINEONE" => $fromAddress1,
		"LINETWO" => $fromAddress2,
		"CITY" => $fromCity,
		"ZIPCODE" => $fromZipcode,
		"SAVECREDITCARDINFO" => $ccSaveCreditCard,
		"STATE" => $fromState
));

// save cc information to the profile (if checked)

$ccSaveCreditCard = framework::getValue('ccSaveCreditCard');
$ccNumber = framework::getValue('ccNumber');
$ccName = framework::getValue('ccName');
$ccExpirationMonth = framework::getValue('ccExpirationMonth');
$ccExpirationYear = framework::getValue('ccExpirationYear');
$ccSecurityCode = framework::getValue('ccSecurityCode');

if ($ccSaveCreditCard) {
	
	framework::log("Saving credit card month = $ccExpirationMonth and year = $ccExpirationYear");
	
	$cc = array(
			"NAMEONCARD" => $ccName,
			"CARDTYPE" => 'VISA',
			"CARDNUMBER" => $ccNumber,
			"EXPIRATIONMONTH" => $ccExpirationMonth,
			"EXPIRATIONYEAR" => $ccExpirationYear,
			"SECURITYCODE" => $ccSecurityCode
	);
	
	Security::saveCreditCard($user['EMAIL'], $cc);
}

$orderId = Administration::createNewOrder($order);

// send order email to the site's admin and send receipt by email
Email::sendNewOrderReceiptEmail($email, $orderId, $lang);

// clean all products from the session before showing the receipt
include_once framework::resolve('packages/store/model/ShoppingCart.php');

ShoppingCart::clearShoppingCart();

// loading the receipt
framework::redirect('store/receipt', '&order=' . $orderId);

