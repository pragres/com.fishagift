<?php

/**
 * Add a post card
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Card.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to dashboard after login
    framework::redirect("base/login", "&returnTo=admin/dashboard");
}

// Reading the POST

foreach ($_POST as $key => $val) {
    $key = strtolower($key);
    $$key = $val;
}

// Working with the images

$u = uniqid();

for ($i = 1; $i <= 3; $i++) {
    $img_name = '';
    if ($_FILES['image' . $i]['tmp_name'] != '') {
	$img_name = "$u-$i-" . Security::getFileNameFor($_FILES['image' . $i]['name']);
	framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/cards/$img_name");
    }
    $nimage = 'image' . $i;
    $$nimage = $img_name;
}

// Inserting in the database
Card::addCard($title, $color1, $color2, $image1, $image2, $image3, $occasion, $defaulttext, $stock, $status, $language);

// Go to the cards's list

framework::redirect("admin/cards");
