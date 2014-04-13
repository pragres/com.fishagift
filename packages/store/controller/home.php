<?php

// including models
include_once framework::resolve('packages/store/model/Items.php');
include_once framework::resolve('packages/base/model/Security.php');

// loading internacionalization
$languages = Security::getLanguages();

$lang = framework::session_get('language');

include_once framework::resolve("packages/store/i18n/$lang/home.php");

// passing variables to the view
$title = $i18n['title'];
$getItemsByType = Items::getItemsByCategory($lang, 54);
$getSimilarItems = Items::getSimilarItems($lang);
$isSessionStarted = Security::isSessionStarted();
$user = Security::getCurrentUser();

// calling the view
include_once framework::resolve('packages/store/view/home.tpl');
