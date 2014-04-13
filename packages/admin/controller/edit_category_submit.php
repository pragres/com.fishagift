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

$orig = Items::getCategoryByID($id);
$item = array();

$data = array();

foreach ($item as $key => $value)
    if ($orig[$key] != $item[$key])
        $data[$key] = $value;

$languages = Security::getLanguages();

$first = true;

foreach ($languages as $lang) {

    $data['NAMESHORT'] = trim($nameshort[$lang['CODE']]);
    $data['NAMELONG'] = trim($namelong[$lang['CODE']]);
    $data['DESCRIPTION'] = trim($description[$lang['CODE']]);

    if ($first) {
        Items::setCategory($id, $data, $lang['CODE']);
        $first = false;
    } else {
        Items::setCategoryTexts($id, $lang['CODE'], $data);
    }
}

framework::redirect("admin/categories", is_null($current_lang) ? '' : '&lang=' . $current_lang);