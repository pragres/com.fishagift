<?php

// including models
include_once framework::resolve('packages/store/model/ShoppingCart.php');
include_once framework::resolve('packages/store/model/Items.php');
include_once framework::resolve('packages/store/model/Card.php');
include_once framework::resolve('packages/store/model/Packing.php');
include_once framework::resolve('packages/store/model/Codifiers.php');
include_once framework::resolve('packages/base/model/Security.php');

// loading internacionalization
$languages = Security::getLanguages();
$lang = framework::session_get('language');
include_once framework::resolve("packages/store/i18n/$lang/store.php");
include_once framework::resolve("packages/base/i18n/$lang/cart.php");
include_once framework::resolve("packages/base/i18n/$lang/modalPopup.php");

$occasions = Codifiers::getOccasions($lang);

// passing variables to the view
$title = $i18n['title'];
$getItemsByPopularity = Items::getItemsByPopularity(24, 0, $lang);
$getWrappingPapers = Packing::getActivePapersByLang($lang);
/*
$getBags = Packing::getActiveBagsByLang($lang);
$getOrnaments = Packing::getActiveOrnamentsByLang($lang);
$getPostcards = Card::getActiveCardsByLang($lang);
*/

// starting user session
$isSessionStarted = Security::isSessionStarted();
$user = Security::getCurrentUser();

// passing shopping cart contents to the view
$getShoppingCart = ShoppingCart::getShoppingCart(true);
$shopping_cart_item = $getShoppingCart['item'];
$shopping_cart_paper = $getShoppingCart['paper'];
/*$shopping_cart_bag = $getShoppingCart['bag'];
$shopping_cart_card = $getShoppingCart['card'];
$shopping_cart_ornaments = $getShoppingCart['ornaments'];
*/
// passing the configurations to the view
$conf = Security::getWebsiteConfigs();
$price_paper = $conf['price_paper'];
/*$price_card = $conf['price_card'];
$price_bag = $conf['price_bag'];
$price_ornament = $conf['price_ornament'];
*/
// calling the view
include_once framework::resolve('packages/store/view/store.tpl');