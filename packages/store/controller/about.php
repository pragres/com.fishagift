<?php

// including models
include_once framework::resolve('packages/base/model/Security.php');

// loading internacionalization
$languages = Security::getLanguages();
$lang = framework::session_get('language');
include_once framework::resolve("packages/store/i18n/$lang/about.php");

// passing variables to the view
$title = $i18n['title'];
$user = Security::getCurrentUser();

// calling the view
include_once framework::resolve('packages/store/view/about.tpl');
