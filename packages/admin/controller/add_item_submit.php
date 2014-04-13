<?php

/**
 * Add an item
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Items.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

foreach ($_POST as $key => $val) {
    $key = strtolower($key);
    $$key = $val;
}

$u = uniqid();

for ($i = 1; $i <= 5; $i++) {
    $img_name = '';
    if ($_FILES['image' . $i]['tmp_name'] != '') {
	$img_name = "$u-$i-" . Security::getFileNameFor($_FILES['image' . $i]['name']);
	framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/items/$img_name");
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
    $sname = $nameshort[$lang['CODE']];
    $lname = $namelong[$lang['CODE']];
    $desc = $description[$lang['CODE']];
    if ($first) {
	Items::addItem($sname, $lname, $desc, $image1, $image2, $image3, $image4, $image5, $width, $height, $base, $weight, $price, $category, $status, '', $stock, $lang['CODE']);
	$first = false;
    } else {
	Items::setItemTexts('LAST_INSERT_ID()', $lang['CODE'], array(
		    'NAMESHORT' => $sname,
		    'NAMELONG' => $lname,
		    'DESCRIPTION' => $desc
		));
    }
}

framework::redirect("admin/items", is_null($current_lang) ? '' : '&lang=' . $current_lang);
