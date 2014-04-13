<?php

/**
 * Preparing the form for edit a post card
 * 
 * @author rafa <rafa@pragres.com>
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Card.php');
include_once framework::resolve('packages/store/model/Codifiers.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to this controller after login
    framework::redirect("base/login", "&returnTo=cards");
}

// Preparing the variables

$id = $_GET['id'];

$card = Card::getCardById($id);

$languages = Security::getLanguages();
$occasions = Codifiers::getOccasions();
$title = $card['TITLE'];
$color1 = $card['COLOR1'];
$color2 = $card['COLOR2'];
$image1 = $card['IMAGE1'];
$image2 = $card['IMAGE2'];
$image3 = $card['IMAGE3'];
$occasion = $card['OCCASION'];
$defaulttext = $card['DEFAULTTEXT'];
$stock = $card['STOCK'];
$language = $card['LANGUAGE'];
$status = $card['STATUS'];
$action = "edit_card";
$form_title = "Edit post card <i>$title</i>";
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

// Showing the view

include framework::resolve('packages/admin/view/form_card.tpl');