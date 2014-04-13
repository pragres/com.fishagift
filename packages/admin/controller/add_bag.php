<?php

/**
 * Preparing the form for add a bag
 * 
 * @author rafa <rafa@pragres.com>
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Codifiers.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to this controller after login
    framework::redirect("base/login", "&returnTo=admin/add_bag");
}

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

// Preparing the variables

$color1 = "";
$color2 = "";
$image1 = "";
$image2 = "";
$image3 = "";
$occasion = "";
$width = "";
$height = "";
$base = "";
$stock = "";
$status = "";

$action = "add";
$title = "New paper bag";

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$occasions = Codifiers::getOccasions();
$languages = Security::getLanguages();

$name = array();
foreach($languages as $lang){
    $name[$lang['CODE']] = '';
}

// Showing the view

include framework::resolve('packages/admin/view/form_bag.tpl');
