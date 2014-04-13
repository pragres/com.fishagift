<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');

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

$orig = Packing::getPaperById($id);
$paper = array();
$paper['COLOR1'] = $color1;
$paper['COLOR2'] = $color2;
$paper['OCCASION'] = $occasion;
$paper['STATUS'] = $status;

$data = array();

foreach ($paper as $key => $value)
    if ($orig[$key] != $paper[$key])
	$data[$key] = $value;

$u = uniqid();

for ($i = 1; $i <= 3; $i++) {
    if (isset($_POST['cboImage' . $i])) {
	$pathimg = "static/images/papers/{$orig['IMAGE' . $i]}";
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
		    framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/papers/$img_name");
		}
		$data['IMAGE' . $i] = $img_name;
		break;
	}
    } else {
	if (isset($_FILES['image' . $i])) {
	    $img_name = '';
	    if ($_FILES['image' . $i]['tmp_name'] != '') {
		$img_name = "$u-$i-" . Security::getFileNameFor($_FILES['image' . $i]['name']);
		framework::copy($_FILES['image' . $i]['tmp_name'], "static/images/papers/$img_name");
	    }
	    $data['IMAGE' . $i] = $img_name;
	}
    }
}

if (isset($data['IMAGE1']))
    $data['IMAGE'] = $data['IMAGE1'];


$languages = Security::getLanguages();

$first = true;

foreach ($languages as $lang) {
    $data['NAME'] = trim($name[$lang['CODE']]);
    $data['DESCRIPTION'] = trim($description[$lang['CODE']]);

    if ($first) {
	Packing::setPaper($id, $data, $lang['CODE']);
	$first = false;
    } else {
	Packing::setPaperTexts($id, $lang['CODE'], $data);
    }
}

framework::redirect("admin/papers", is_null($current_lang) ? '' : '&lang=' . $current_lang);