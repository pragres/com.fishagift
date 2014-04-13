<?php

// including models
include_once framework::resolve('packages/store/model/Items.php');
include_once framework::resolve('packages/base/model/Security.php');

// loading internacionalization
$languages = Security::getLanguages();
$lang = framework::session_get('language');

include_once framework::resolve("packages/store/i18n/$lang/item.php");

// get params from URL
$id = $_GET['id'];

// bringing data from the db
$getItemByID = Items::getItemByID($id, $lang);
$getSimilarItems = Items::getSimilarItems($id);

// starting user session
$isSessionStarted = Security::isSessionStarted();
$user = Security::getCurrentUser();

// passing variables to the view
$pictures = array_filter(Array($getItemByID["IMAGE1"], $getItemByID["IMAGE2"], $getItemByID["IMAGE3"], $getItemByID["IMAGE4"], $getItemByID["IMAGE5"]));
$title = $getItemByID['NAMELONG'];

// calling the view
include_once framework::resolve('packages/store/view/item.tpl');
