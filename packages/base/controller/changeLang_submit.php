<?php

include_once framework::resolve('packages/base/model/Security.php');

// collecting data from post
$language = framework::getValue('language') == "" ? "en" : framework::getValue('language');
$returnTo = framework::getValue('returnTo') == "" ? "store/home" : framework::getValue('returnTo');

// changing language
framework::session_set('language', $language);

$user = Security::getCurrentUser();

if (!is_null($user)){
	$user['LANGUAGE'] = $language;
	unset($uset['PASSWORD']);
	Security::updateUserInformation($user['EMAIL'], $user);
}

// redirecting
unset($_GET['returnTo']);
unset($_GET['page']);
unset($_GET['package']);
unset($_GET['language']);

framework::redirect($returnTo, '&'.framework::getCurrentUrlQuery());
