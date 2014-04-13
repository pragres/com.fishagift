<?php

// including models
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/admin/model/Administration.php');

// loading internacionalization
$languages = Security::getLanguages();
$lang = framework::session_get('language');
include_once framework::resolve("packages/store/i18n/$lang/fished.php");

// passing variables to the view
$title = $i18n['title'];
$isSessionStarted = Security::isSessionStarted();
$user = Security::getCurrentUser();

$orders = Administration::getOrders(null, null, "Sender = '{$user['EMAIL']}'");

foreach ( $orders as $idx => $order ) {
	$orders[$idx] = Administration::getOrderDetails($order['TRANSACTION'], $lang);
}

// redirect to the login page if session is not started
if (! $isSessionStarted) {
	header("Location: " . framework::link_to('base/login') . "&returnTo=store/fished");
	exit();
}

// passing the configurations to the view
$conf = Security::getWebsiteConfigs();
$price_paper = $conf['price_paper'];
$price_card = $conf['price_card'];
$price_bag = $conf['price_bag'];
$price_ornament = $conf['price_ornament'];

// calling the view
include_once framework::resolve('packages/store/view/fished.tpl');
