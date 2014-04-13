<?php

// including models
include_once framework::resolve('packages/store/model/ShoppingCart.php');
include_once framework::resolve('packages/store/model/Codifiers.php');
include_once framework::resolve('packages/store/model/Items.php');
include_once framework::resolve('packages/store/model/Card.php');
include_once framework::resolve('packages/store/model/Packing.php');
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/base/model/Shipping.php');
include_once 'libs/Stripe/config.php';

// loading internacionalization
$lang = framework::session_get('language');
$languages = Security::getLanguages();
include_once framework::resolve("packages/store/i18n/$lang/send.php");

// loading user information from the session
$isSessionStarted = Security::isSessionStarted();
$user = Security::getCurrentUser();

// redirect to the login page if session is not started
if (!$isSessionStarted) {
    header("Location: " . framework::link_to('base/login'));
    exit;
}

// check if the shopping cart has at least an item and a paper, else redirect the store
$isReadyToCheckout = ShoppingCart::isReadyToCheckout();
if (!$isReadyToCheckout) {
    header("Location: " . framework::link_to('store/store'));
    exit;
}

// If the PayPal purchase was cancelled, the user will be redirected to this page
// and all fields will be pre-populated so he/she can easily pick another payment method.
// The code below populates the fields in address_to
$toFirstName = $toLastName = $toAddress1 = $toAddress2 = $toCity = $toCountry = $toZipcode = "";
if (framework::session_exists("order_address_to")) {
    $addressTo = framework::session_get("order_address_to");
    $toFirstName = $addressTo['toFirstName'];
    $toLastName = $addressTo['toLastName'];
    $toAddress1 = $addressTo['toAddress1'];
    $toAddress2 = $addressTo['toAddress2'];
    $toCity = $addressTo['toCity'];
    $toCountry = $addressTo['toCountry'];
    $toZipcode = $addressTo['toZipcode'];
}

// passing the configurations to the view
$conf = Security::getWebsiteConfigs();
$price_paper = $conf['price_paper'];
/*
$price_card = $conf['price_card'];
$price_bag = $conf['price_bag'];
$price_ornament = $conf['price_ornament'];
*/
// passing shopping cart contents to the view
$getShoppingCart = ShoppingCart::getShoppingCart(true);

$shopping_cart_item = $getShoppingCart['item'];
$shopping_cart_paper = $getShoppingCart['paper'];
$shopping_cart_shipping = $getShoppingCart['shipping'];
$shopping_cart_price = $getShoppingCart['price'];

/*
$shopping_cart_bag = $getShoppingCart['bag'];
$shopping_cart_card = $getShoppingCart['card'];
$shopping_cart_ornaments = $getShoppingCart['ornaments'];
*/
// Calculte shipping prices and send them to the interface
$width = $shopping_cart_item['WIDTH'];
$height = $shopping_cart_item['HEIGHT'];
$base = $shopping_cart_item['BASE'];
$shipping_prices = Shipping::getBestShippingOptions($width, $height, $base);

// passing variables to the view
$title = $i18n['title'];
$stripe_publishable_key = $stripe['publishable_key'];
$tax = Security::getTaxByPrice($shopping_cart_price); // @TODO NOT WORKING WELL
$shipping = $shopping_cart_shipping['price'];
$total = $shopping_cart_price + $tax + $shipping;

$fromName = $user['FULLNAME'];
$fromAddress1 = $user['LINEONE'];
$fromAddress2 = $user['LINETWO'];
$fromState = $user['STATE'];
$fromCity = $user['CITY'];
$fromZipcode = $user['ZIPCODE'];

$ccName = $user['NAMEONCARD'];
$ccNumber = $user['CARDNUMBER'];
$ccExpirationMonth = $user['EXPIRATIONMONTH'];
$ccExpirationYear = $user['EXPIRATIONYEAR'];
$ccSecurityCode = $user['SECURITYCODE'];

$states = Codifiers::getStates();

// calling the view
include_once framework::resolve('packages/store/view/send.tpl');
