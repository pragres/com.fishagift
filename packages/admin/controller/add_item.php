<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Items.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

// Preparing texts
$nameshort = array();
$namelong = array();
$description = array();

$languages = Security::getLanguages();

foreach ($languages as $lang) {
    $nameshort[$lang['CODE']] = '';
    $namelong[$lang['CODE']] = '';
    $description[$lang['CODE']] = '';
}

$price = '';
$stock = '';
$category = 0;
$status = 0;

$weight = '';
$height = '';
$base = '';
$width = '';
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$form_title = "Add a new item";
$categories = Items::getCategories();

include framework::resolve('packages/admin/view/form_item.tpl');
