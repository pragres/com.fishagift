<?php

/**
 * Clean the unmatched images
 * 
 * @author rafa <rafa@pragres.com>
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/admin/model/Administration.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to this controller after login
    framework::redirect("base/login", "&returnTo=admin/clear_images");
}

// Preparing the variables

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

$result = Administration::clearImages();

// Showing the view

include framework::resolve('packages/admin/view/clear_images_result.tpl');