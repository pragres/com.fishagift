<?php

/**
 * Add a category
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 * @package admin
 */
// Including the model

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Items.php');

// Checking the security

if (!Security::isSessionStartedByAdmin()) {
    // Return to dashboard after login
    framework::redirect("base/login", "&returnTo=admin/dashboard");
}

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

// Reading the POST

foreach ($_POST as $key => $val) {
    $key = strtolower($key);
    $$key = $val;
}


$languages = Security::getLanguages();

$first = true;

foreach ($languages as $lang) {
    $sname = $nameshort[$lang['CODE']];
    $lname = $namelong[$lang['CODE']];
    $desc = $description[$lang['CODE']];
    if ($first) {
        Items::addCategory($sname, $lname, $desc);
        $first = false;
    } else {
        Items::setCategoryTexts('LAST_INSERT_ID()', $lang['CODE'], array(
                    'NAMESHORT' => $sname,
                    'NAMELONG' => $lname,
                    'DESCRIPTION' => $desc
                ));
    }
}

// Go to the cards's list

framework::redirect("admin/categories");
