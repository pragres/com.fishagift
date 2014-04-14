<?php

// including models
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/admin/model/Administration.php');

// redirect to the login page if session is not started or the order was not previously created
$isSessionStarted = Security::isSessionStarted();
$orderIsOpened = true; // @TODO make a function in the model for this

/*
 * if (!$isSessionStarted || !$orderIsOpened) { header("Location: " . framework::link_to('store/home')); exit; }
 */
$orderId = $_GET['order'];
$user = Security::getCurrentUser();

$order = Administration::getOrderDetails($orderId);

// redirect to the login page if session is not started
if (! $isSessionStarted) {
	framework::redirect('base/login', '&returnTo=store/receipt&order=' . $orderId);
	exit();
}

// redirect to home if error in order
if (is_null($order)) {
	framework::redirect('store/home');
	exit();
}

// mask the cc to show only the last 4 digits
$ccNumber = "";
if (isset($order['SENDER']['CREDITCARD'])){
	$ccNumber = $order['SENDER']['CREDITCARD']['CARDNUMBER'];
	$ccNumber = "XXXX-XXXX-XXXX-" . substr($ccNumber, -4);
}

// formatting date in a human readable way
$arrivalDate = date("m/d/Y", strtotime($order['DATE']));

// Checking the owner
/*
 * if ($order['SENDER'] != $user['EMAIL']) framework::redirect("store/home");
 */

// loading internacionalization
$languages = Security::getLanguages();
$lang = framework::session_get('language');

include_once framework::resolve("packages/store/i18n/$lang/orderdetails.php");

// load configurations for this view.
$conf = Security::getWebsiteConfigs();
$price_paper = $conf['price_paper'];

/*
 * $price_card = $conf['price_card']; $price_bag = $conf['price_bag']; $price_ornament = $conf['price_ornament'];
 */
// passing variables to the view
$title = $i18n['title'];

// calling the view
include_once framework::resolve('packages/store/view/orderdetails.tpl');
