<?php

/**
 * Add a bag
 *
 * @author rafa <rafa@pragres.com>
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');

// Checking the security
if (!Security::isSessionStartedByAdmin()) {
    // Return to dashboard after login
    framework::redirect("base/login", "&returnTo=admin/dashboard");
}

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

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
	framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/bags/$img_name");
    }
    $nimage = 'image' . $i;
    $$nimage = $img_name;
}
/*
  foreach ($_FILES as $key => $val)
  $$key = $val['name'];
 */
// Inserting in the database
$languages = Security::getLanguages();
$first = true;
foreach ($languages as $lang) {

    if ($first) {
	Packing::addBag($name[$lang['CODE']], $color1, $color2, $occasion, $width, $height, $base, $status, $stock, $image1, $image2, $image3, $lang['CODE']);
	$first = false;
    } else {
	Packing::setBagTexts('LAST_INSERT_ID()', $lang['CODE'], array(
		    'NAME' => $name[$lang['CODE']]
		));
    }
}

// Go to the bags's list

framework::redirect("admin/bags", is_null($current_lang) ? '' : '&lang=' . $current_lang);

