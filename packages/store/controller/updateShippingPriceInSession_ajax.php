<?php
// getting data from get
$newShippingPrice = $_GET["price"];
$shippingMethod = $_GET["shippingMethod"];
$carrier = $_GET["carrier"];

// adding to the session varible
include_once framework::resolve('packages/store/model/ShoppingCart.php');
ShoppingCart::setShippingDetails($newShippingPrice, $shippingMethod, $carrier);
