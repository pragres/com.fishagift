<?php

/**
 * Update an ornament
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to dashboard after login
    framework::redirect("base/login", "&returnTo=admin/ornaments");
}

foreach ($_POST as $key => $val) {
    $key = strtolower($key);
    $$key = $val;
}

$id = $_GET['id'];
$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];
$orig = Packing::getOrnamentById($id);

$orig['IMAGE1'] = $orig['IMAGE'];
$ornament = array();
$ornament['OCCASION'] = $occasion;
$ornament['STOCK'] = $stock;
$ornament['STATUS'] = $status;

$data = array();

foreach ($ornament as $key => $value)
    if ($orig[$key] != $ornament[$key])
	$data[$key] = $value;

$u = uniqid();

for ($i = 1; $i <= 1; $i++) {
    if (isset($_POST['cboImage' . $i])) {
	$pathimg = "static/images/ornaments/{$orig['IMAGE' . $i]}";
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
		    framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/ornaments/$img_name");
		}
		$data['IMAGE' . $i] = $img_name;
		break;
	}
    } else {
	if (isset($_FILES['image' . $i])) {
	    $img_name = '';
	    if ($_FILES['image' . $i]['tmp_name'] != '') {
		$img_name = "$u-$i-" . Security::getFileNameFor($_FILES['image' . $i]['name']);
		framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/ornaments/$img_name");
	    }
	    $data['IMAGE' . $i] = $img_name;
	}
    }
}

if (isset($data[
		'IMAGE1']))
    $data['IMAGE'] = $data['IMAGE1'];

$languages = Security::getLanguages();

$first = true;

foreach ($languages as $lang) {
    $data['NAME'] = trim($name[$lang['CODE']]);
    $data['DESCRIPTION'] = trim($description[$lang['CODE']]);

    if ($first) {
	Packing::setOrnament($id, $data, $lang['CODE']);
	$first = false;
    } else {
	Packing::setOrnamentTexts($id, $lang['CODE'], $data);
    }
}

framework::redirect("admin/ornaments", is_null($current_lang) ? '' : '&lang=' . $current_lang);