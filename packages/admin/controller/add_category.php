<?php

/**
 * Preparing the form for add a category
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to this controller after login
    framework::redirect("base/login", "&returnTo=admin/add_category");
}

// Preparing the variables
$languages = Security::getLanguages();

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

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$action = "add_category";
$form_title = "Add a new category";

// Showing the view

include framework::resolve('packages/admin/view/form_category.tpl');
