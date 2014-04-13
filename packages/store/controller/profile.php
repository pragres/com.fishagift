<?php

// including models
include_once framework::resolve('packages/store/model/ShoppingCart.php');
include_once framework::resolve('packages/store/model/Codifiers.php');
include_once framework::resolve('packages/base/model/Security.php');

// loading internacionalization
$lang = framework::session_get('language');
$languages = Security::getLanguages();
include_once framework::resolve("packages/store/i18n/$lang/profile.php");

// redirect to the login page if session is not started
$isSessionStarted = Security::isSessionStarted();
if (!$isSessionStarted) {
    header("Location: " . framework::link_to('store/home'));
    exit;
}

// variables to pass to the view
$title = $i18n['title'];
$user = Security::getCurrentUser();

$fullName = $user['FULLNAME'];
$sex = $user['SEX']; 
$dateOfBirth = $user['BIRTHDATE'];
$subscribe = $user['SUBSCRIBENEWS'];
$address1 = $user['LINEONE'];
$address2 = $user['LINETWO'];
$city = $user['CITY'];
$country = "United States";
$zipcode = $user['ZIPCODE'];
$ccName = $user['NAMEONCARD'];
$ccNumber = $user['CARDNUMBER'];
$ccExpirationMonth = $user['EXPIRATIONMONTH'];
$ccExpirationYear = $user['EXPIRATIONYEAR'];
$ccSecurityCode = $user['SECURITYCODE'];

$statesUSA = Codifiers::getStates();

// calling the view
include_once framework::resolve('packages/store/view/profile.tpl');
