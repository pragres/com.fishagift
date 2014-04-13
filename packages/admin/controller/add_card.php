<?php

/**
 * Preparing the form for add a post card
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
    framework::redirect("base/login", "&returnTo=admin/add_card");
}

// Preparing the variables
$languages = Security::getLanguages();
$occasions = Codifiers::getOccasions();
$title = "";
$color1 = "";
$color2 = "";
$image1 = "";
$image2 = "";
$image3 = "";
$occasion = "";
$defaulttext = "";
$stock = "";
$language = "";
$status = "";
$action = "add_card";
$form_title = "Add a post card";
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

// Showing the view

include framework::resolve('packages/admin/view/form_card.tpl');
