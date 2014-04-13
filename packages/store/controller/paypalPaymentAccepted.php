<?php

include_once framework::resolve('packages/base/model/Security.php');

// if the user does not started the purchase from before, then order_address_to
// will not be saved in the session. Do not let his/her create a new order
// Every purchase MUST start in the payBy*.php pages, which should include the file "saveInfoToProfileWhenPurchase.php"
if (!framework::session_exists("order_address_to")) {
    Security::logAndAlertError("No order can be created, Address To does not exist", "HIGH");
    header("Location: " . framework::link_to('store/home'));
}

// confirm paypal payment
$token = $_GET['token'];
$payerID = $_GET['PayerID'];
$api = framework::$config['paypal']['api'];
$paypal_execute_url = framework::session_get("paypal_execute_url");
$paypal_authorization = framework::session_get("paypal_authorization");

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // @TODO import certs and remove this line
curl_setopt($ch, CURLOPT_URL, $paypal_execute_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type:application/json", "Authorization:$paypal_authorization"));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"payer_id" : "' . $payerID . '"}');
$response = curl_exec($ch);
echo curl_error($ch);
curl_close($ch);


// Getting the confirmation number to add to the order. Confirmation # is super important, so it should be
// sent to the user and stored. It is the way to find a previous order on PayPal in case we need to refund it
$response = json_decode($response);
$confirmationNumber = $response->transactions[0]->related_resources[0]->sale->id;


include_once framework::resolve('packages/store/model/ShoppingCart.php');
/*
  include_once framework::resolve('packages/email/model/Email.php');
  include_once framework::resolve('packages/admin/model/Administration.php');

  // bring user name and lastname from the database.
  $userFullName = Array(); // @TODO create a function getUserFullName() in the Admin model, if there is not another function for it

  // bring user address from the database.
  $addressFrom = Array(); // @TODO create a function getUserAddress() in the Admin model, if there is not another function for it

  // loading destination address from the session
  $addressTo = framework::session_get('order_address_to');
  $paymentMethod = "PP";

  // passing the configurations to the view
  $conf = Security::getWebsiteConfigs();
  $price_paper = $conf['price_paper'];
  $price_card = $conf['price_card'];
  $price_bag = $conf['price_bag'];
  $price_ornament = $conf['price_ornament'];

  // passing shopping cart contents to the view
  $getShoppingCart = ShoppingCart::getShoppingCart();
  $shopping_cart_item = $getShoppingCart['item'];
  $shopping_cart_paper = $getShoppingCart['paper'];
  $shopping_cart_bag = $getShoppingCart['bag'];
  $shopping_cart_card = $getShoppingCart['card'];
  $shopping_cart_ornaments = $getShoppingCart['ornaments'];
  $shopping_cart_shipping = $getShoppingCart['shipping'];
  $shopping_cart_price = $getShoppingCart['price'];

  // passing variables to the view
  $title = "Receipt";
  $tax = Security::getTaxByPrice($shopping_cart_price);
  $shipping = $shopping_cart_shipping['price'];
  $total = $shopping_cart_price + $tax + $shipping;

  // creating work order
  // I HAVE NO IDEA HOW THIS FUNCTION FROM THE MODEL WORKS OR WHAT TO PASS TO IT. RAFA PLEASE TAKE CARE
  $orderId = Administration::createNewOrder(NULL);

  // send order email to the site's admin and send receipt by email
  Email::sendNewOrderReceiptEmail($email, $orderId);
 */

// clean all products from the session before showing the receipt
ShoppingCart::clearShoppingCart();
framework::session_unset('order_address_to');
framework::session_unset('paypal_execute_url');
framework::session_unset('paypal_authorization');

// loading the receipt
header("Location: " . framework::link_to('store/receipt'));
