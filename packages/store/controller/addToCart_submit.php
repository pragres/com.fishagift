<?php

// getting data from get
$id = $_GET["id"];
$type = $_GET["type"];
$price = $_GET["price"];

// adding to cart
include_once framework::resolve('packages/store/model/ShoppingCart.php');
ShoppingCart::addToShoppingCart($id, $type, $price);

// returning to the store
header("Location: " . framework::link_to('store/store'));
