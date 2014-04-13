<?php

/**
 * Prepare a form for add a new ornament
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Codifiers.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to this controller after login
    framework::redirect("base/login", "&returnTo=admin/add_ornament");
}


$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];
$languages = Security::getLanguages();

foreach ($languages as $lang) {
    $name[$lang['CODE']] = '';
    $description[$lang['CODE']] = '';
}

$occasions = Codifiers::getOccasions();
$image1 = "";
$occasion = "";
$stock = "";
$status = "";
$action = "add_ornament";
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$form_title = 'Add a new ornament';

include framework::resolve('packages/admin/view/form_ornament.tpl');