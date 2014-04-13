<?php

// getting data from get
$id = $_GET["id"];
$type = $_GET["type"];
$price = $_GET["price"];

// removing from cart
include_once framework::resolve('packages/store/model/ShoppingCart.php');
ShoppingCart::deleteFromShoppingCart($id, $type, $price);
