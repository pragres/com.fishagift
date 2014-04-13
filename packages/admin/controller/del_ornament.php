<?php

/**
 * Delete an ornament/decoration
 * 
 * @author rafa <rafa@pragres.com>
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');

// Reading the GET

$Id = $_GET['id'];

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to this controller after login
    framework::redirect("base/login", "&returnTo=admin/del_ornament&id=$Id");
}

// Deleting the record

Packing::delOrnament($Id);

// Goto ornaments's list

framework::redirect("admin/ornaments", is_null($current_lang) ? '' : '&lang=' . $current_lang);