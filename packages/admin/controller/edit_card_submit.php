<?php

/**
 * Update a post card
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Card.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

foreach ($_POST as $key => $val) {
    $key = strtolower($key);
    $$key = $val;
}

$id = $_GET['id'];
$orig = Card::getCardById($id);
$card = array();

// Analizing the status

$status = $status == "A" ? "Active" : "Inactive";

$card['TITLE'] = $title;
$card['COLOR1'] = $color1;
$card['COLOR2'] = $color2;
$card['OCCASION'] = $occasion;
$card['DEFAULTTEXT'] = $defaulttext;
$card['STOCK'] = $stock;
$card['STATUS'] = $status;
$card['LANGUAGE'] = $language;

$data = array();

foreach ($card as $key => $value)
    if ($orig[$key] != $card[$key])
	$data[$key] = $value;

$u = uniqid();

for ($i = 1; $i <= 3; $i++) {
    if (isset($_POST['cboImage' . $i])) {
	$pathimg = "static/images/cards/{$orig['IMAGE' . $i]}";
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
		    framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/cards/$img_name");
		}
		$data['IMAGE' . $i] = $img_name;
		break;
	}
    } else {
	if (isset($_FILES['image' . $i])) {
	    $img_name = '';
	    if ($_FILES['image' . $i]['tmp_name'] != '') {
		$img_name = "$u-$i-" . Security::getFileNameFor($_FILES['image' . $i]['name']);
		framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/cards/$img_name");
	    }
	    $data['IMAGE' . $i] = $img_name;
	}
    }
}

Card::setCard($id, $data);

framework::redirect("admin/cards");