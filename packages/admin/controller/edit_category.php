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

$item = Items::getCategoryById($id);

$texts = Items::getCategoryTexts($id);
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

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$form_title = "Edit category";
$action = "edit_category";

include framework::resolve('packages/admin/view/form_category.tpl');
