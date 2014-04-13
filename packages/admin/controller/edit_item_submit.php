<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Items.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

foreach ($_POST as $key => $val) {
    $key = strtolower($key);
    $$key = $val;
}

$id = $_GET['id'];
$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

$orig = Items::getItemByID($id);
$item = array();
$item['PRICE'] = $price;
$item['STOCK'] = $stock;
$item['CATEGORY'] = $category;
$item['STATUS'] = $status;
$item['WIDTH'] = $width;
$item['HEIGHT'] = $height;
$item['BASE'] = $base;
$item['WEIGHT'] = $weight;

$data = array();

foreach ($item as $key => $value)
    if ($orig[$key] != $item[$key])
	$data[$key] = $value;

$u = uniqid();

for ($i = 1; $i <= 5; $i++) {
    if (isset($_POST['cboImage' . $i])) {
	$pathimg = "static/images/items/{$orig['IMAGE' . $i]}";
	switch ($_POST['cboImage' . $i]) {
	    case 1: // keep
		break;
	    case 2: // remove
		if (file_exists($pathimg) && is_file($pathimg))
		    unlink($pathimg);
		$data['IMAGE' . $i] = '';
		break;
	    case 3: // change
		if (file_exists($pathimg) && is_file($pathimg))
		    unlink($pathimg);
		$img_name = '';
		if ($_FILES['image' . $i]['tmp_name'] != '') {
		    $img_name = "$u-$i-" . Security::getFileNameFor($_FILES['image' . $i]['name']);
		    framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/items/$img_name");
		}
		$data['IMAGE' . $i] = $img_name;
		break;
	}
    } else {
	if (isset($_FILES['image' . $i])) {
	    $img_name = '';
	    if ($_FILES['image' . $i]['tmp_name'] != '') {
		$img_name = "$u-$i-" . Security::getFileNameFor($_FILES['image' . $i]['name']);
		framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/items/$img_name");
	    }
	    $data['IMAGE' . $i] = $img_name;
	}
    }
}

$languages = Security::getLanguages();

$first = true;

foreach ($languages as $lang) {

    $data['NAMESHORT'] = trim($nameshort[$lang['CODE']]);
    $data['NAMELONG'] = trim($namelong[$lang['CODE']]);
    $data['DESCRIPTION'] = trim($description[$lang['CODE']]);

    if ($first) {
	Items::setItem($id, $data, $lang['CODE']);
	$first = false;
    } else {
	Items::setItemTexts($id, $lang['CODE'], $data);
    }
}

framework::redirect("admin/items", is_null($current_lang) ? '' : '&lang=' . $current_lang);