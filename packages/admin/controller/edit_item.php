<?php

/**
 * Preparing a form for edit an item
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Items.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$id = $_GET['id'];
$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

$item = Items::getItemById($id);

$texts = Items::getItemTexts($id);
$languages = Security::getLanguages();

$nameshort = array();
$namelong = array();
$description = array();

foreach($languages as $lang){
    $nameshort[$lang['CODE']] = "";
    $namelong[$lang['CODE']] = "";
    $description[$lang['CODE']] = "";
}

if (is_array($texts)) foreach ($texts as $text) {
    $nameshort[$text['LANGUAGE']] = $text['NAMESHORT'];
    $namelong[$text['LANGUAGE']] = $text['NAMELONG'];
    $description[$text['LANGUAGE']] = $text['DESCRIPTION'];
}

$price = $item['PRICE'];
$stock = $item['STOCK'];
$category = $item['CATEGORY'];
$status = $item['STATUS'];

$width = $item['WIDTH'];
$height = $item['HEIGHT'];
$base = $item['BASE'];
$weight = $item['WEIGHT'];

$image1 = $item['IMAGE1'];
$image2 = $item['IMAGE2'];
$image3 = $item['IMAGE3'];
$image4 = $item['IMAGE4'];
$image5 = $item['IMAGE5'];

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$form_title = "Edit item";
$categories = Items::getCategories();
$action = "edit_item";

include framework::resolve('packages/admin/view/form_item.tpl');
