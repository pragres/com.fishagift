<?php

/**
 * Preparing a form for edit ornament
 * 
 * @author rafa <rafa@pragres.com>
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');
include_once framework::resolve('packages/store/model/Codifiers.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to this controller after login
    framework::redirect("base/login", "&returnTo=admin/ornaments");
}

// Preparing the variables
$id = $_GET['id'];
$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];
$texts = Packing::getOrnamentTexts($id);
$languages = Security::getLanguages();

$name = array();
$description = array();

foreach($languages as $lang){
    $name[$lang['CODE']] = "";
    $description[$lang['CODE']] = "";
}

if (is_array($texts)) foreach ($texts as $text) {
    $name[$text['LANGUAGE']] = $text['NAME'];
    $description[$text['LANGUAGE']] = $text['DESCRIPTION'];
}

$ornament = Packing::getOrnamentById($id);
$occasions = Codifiers::getOccasions();
$image1 = $ornament['IMAGE'];
$occasion = $ornament['OCCASION'];
$stock = $ornament['STOCK'];
$status = $ornament['STATUS'];
$action = "edit_ornament";
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$form_title = 'Edit an ornament';


// Showing the view

include framework::resolve('packages/admin/view/form_ornament.tpl');