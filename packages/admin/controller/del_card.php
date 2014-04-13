<?php

/**
 * Delete a post card
 * 
 * @author rafa <rafa@pragres.com>
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Card.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to this controller after login
    framework::redirect("base/login", "&returnTo=admin/del_card&id=".$_GET['id']);
}

// Preparing the variables

$id = $_GET['id'];

// Deleting the card

Card::delCardById($id);

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

// Goto cards's list

framework::redirect("admin/cards");