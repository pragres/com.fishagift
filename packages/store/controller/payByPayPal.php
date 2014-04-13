<?php

// redirect to the login page if session is not started
$isSessionStarted = true;
if (!$isSessionStarted)
    header("Location: " . framework::link_to('store/home'));

// loading PayPal API key
$api = framework::$config['paypal']['api'];
$client_id = framework::$config['paypal']['client_id'];
$secret = framework::$config['paypal']['secret'];

include_once framework::resolve('packages/store/model/ShoppingCart.php');
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/admin/model/Administration.php');

// loading info from the shopping cart
$getShoppingCart = ShoppingCart::getShoppingCart(true);
$desc = htmlentities($getShoppingCart['item']["NAMESHORT"]);
$price = number_format($getShoppingCart['price'], 2);
$tax = number_format(floor((Security::getTaxByPrice($price) * 100)) / 100, 2);
$shipping = number_format($getShoppingCart['shipping']['price'], 2);
$total = number_format($price + $tax + $shipping, 2);

// authenticating in PayPal
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // @TODO import certs and remove this line
curl_setopt($ch, CURLOPT_USERPWD, $client_id . ':' . $secret);
curl_setopt($ch, CURLOPT_URL, "https://$api/v1/oauth2/token");
curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Accept: application/json", "Accept-Language: en_US"));
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo curl_error($ch);
$response = curl_exec($ch);
curl_close($ch);

// obtaining authorization code
$response = json_decode($response);
$auth = $response->token_type . ' ' . $response->access_token;

// creating json object
$request = '{
		"intent":"sale",
		"redirect_urls":{
			"cancel_url":"' . framework::link_to('store/paypalPaymentCanceled', false) . '",
			"return_url":"' . framework::link_to('store/paypalPaymentAccepted', false) . '"
		},
		"payer":{
			"payment_method":"paypal"
		},
		"transactions":[{
			"amount":{
				"total":"' . $total . '",
				"currency":"USD",
				"details":{
					"subtotal":"' . $price . '",
					"tax":"' . $tax . '",
					"shipping":"' . $shipping . '"
				}
			},
			"description":"' . $desc . '"
		}]
	}';

// request payment to PayPal
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // @TODO import certs and remove this line
curl_setopt($ch, CURLOPT_URL, "https://$api/v1/payments/payment");
curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type:application/json", "Authorization:$auth"));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
$response = curl_exec($ch);
echo curl_error($ch);
curl_close($ch);


/*
  // save name and last name to the profile
  $fromFirstName = framework::getValue('fromFirstName');
  $fromLastName = framework::getValue('fromLastName');
  Administration::setNameToProfile($email, $fromFirstName, $fromLastName);


  // save address from to the profile
  $fromAddress1 = framework::getValue('fromAddress1');
  $fromAddress2 = framework::getValue('fromAddress2');
  $fromCity = framework::getValue('fromCity');
  $fromCountry = framework::getValue('fromCountry');
  $fromZipcode = framework::getValue('fromZipcode');
  Administration::setFromAddress($email, $fromAddress1, $fromAddress2, $fromCity, $fromCountry, $fromZipcode);
 */

// save address_to to the session to create the order once the user confirm the payment
$toFirstName = framework::getValue('toFirstName');
$toLastName = framework::getValue('toLastName');
$toAddress1 = framework::getValue('toAddress1');
$toAddress2 = framework::getValue('toAddress2');
$toCity = framework::getValue('toCity');
$toCountry = framework::getValue('toCountry');
$toZipcode = framework::getValue('toZipcode');

$addressTo = Array(
    "toFirstName" => $toFirstName,
    "toLastName" => $toLastName,
    "toAddress1" => $toAddress1,
    "toAddress2" => $toAddress2,
    "toCity" => $toCity,
    "toCountry" => $toCountry,
    "toZipcode" => $toZipcode
);
framework::session_set('order_address_to', $addressTo);


// redirecting user to paypal
$url = false;
$response = json_decode($response);
framework::session_set('paypal_authorization', $auth);

$links = $response->links;
foreach ($links as $link) {
    if ($link->rel == "execute")
	framework::session_set('paypal_execute_url', $link->href); // capture url to execute
 if ($link->rel == "approval_url")
	$url = $link->href; // capture url to approve

}
if ($url)
    header("Location: $url");


// handle unexpected errors
echo "Unexpected error happened: cannot connect with PayPal. We are really sorry, we have received this message too, so we can fix t right away. Please try later.";
Security::logAndAlertError("Cannot connect with PayPal", "HIGH");
