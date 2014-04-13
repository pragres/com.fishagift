<?php

/**
 * Add a new paper
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
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

for ($i = 1; $i <= 1; $i++) {
    $img_name = '';
    if ($_FILES['image' . $i]['tmp_name'] != '') {
	$img_name = "$u-$i-" . Security::getFileNameFor($_FILES['image' . $i]['name']);
	framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/papers/$img_name");
    }
    $nimage = 'image' . $i;
    $$nimage = $img_name;
}
/*
  foreach ($_FILES as $key => $val)
  $$key = $val['name'];
 */
$languages = Security::getLanguages();

$first = true;

foreach ($languages as $lang) {
    $sname = $name[$lang['CODE']];
    $desc = $description[$lang['CODE']];
    if ($first) {
	Packing::addPaper($color1, $color2, $occasion, $image1, $sname, $desc, $status, $lang['CODE']);
	$first = false;
    } else {
	Packing::setPaperTexts('LAST_INSERT_ID()', $lang['CODE'], array(
		    'NAME' => $sname,
		    'DESCRIPTION' => $desc
		));
    }
}

// Go to the papers's list
framework::redirect("admin/papers", is_null($current_lang) ? '' : '&lang=' . $current_lang);
