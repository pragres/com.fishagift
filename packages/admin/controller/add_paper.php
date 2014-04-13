<?php

/**
 * Preparing the form for add a new paper
 * 
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Codifiers.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to this controller after login
    framework::redirect("base/login", "&returnTo=admin/add_paper");
}

// Preparing the variables

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

$occasions = Codifiers::getOccasions();
$languages = Security::getLanguages();

foreach ($languages as $lang) {
    $name[$lang['CODE']] = '';
    $description[$lang['CODE']] = '';
}

$color1 = "";
$color2 = "";
$image1 = "";
$occasion = "";
$status = "";

$action = "add";
$title = "New paper";
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

// Showing the view

include framework::resolve('packages/admin/view/form_paper.tpl');
