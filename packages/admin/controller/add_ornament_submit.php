<?php

/**
 * Add a ornament/decoration
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
    framework::redirect("base/login", "&returnTo=admin/ornaments");
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

for ($i = 1; $i <= 1; $i++) {
    $img_name = '';
    if ($_FILES['image' . $i]['tmp_name'] != '') {
	$img_name = "$u-$i-" . Security::getFileNameFor($_FILES['image' . $i]['name']);
	framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/ornaments/$img_name");
    }
    $nimage = 'image' . $i;
    $$nimage = $img_name;
}

// Inserting in the database


$languages = Security::getLanguages();

$first = true;

foreach ($languages as $lang) {
    $sname = $name[$lang['CODE']];
    $desc = $description[$lang['CODE']];
    if ($first) {
	Packing::addOrnament($sname, $desc, $occasion, $image1, $stock, $status);
	$first = false;
    } else {
	Packing::setOrnamentTexts('LAST_INSERT_ID()', $lang['CODE'], array(
		    'NAME' => $sname,
		    'DESCRIPTION' => $desc
		));
    }
}

// Go to the ornaments's list

framework::redirect("admin/ornaments", is_null($current_lang) ? '' : '&lang=' . $current_lang);
