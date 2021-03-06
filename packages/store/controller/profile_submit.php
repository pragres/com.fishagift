<?php
include_once framework::resolve('packages/base/model/Security.php');

if (! Security::isSessionStarted())
	framework::redirect("base/login");

$subscribe = 0;
$country = 'United States';

foreach ( $_POST as $key => $value )
	$$key = $value;

$user = Security::getCurrentUser();

if (! isset($newPassword))
	$newPassword = '';

$wrongOldPassword = false;

if (md5($oldPassword) != $user['PASSWORD'] && $oldPassword != '') {
	$wrongOldPassword = true;
	include_once framework::resolve('packages/store/view/profile.tpl');
} else {
	
	$profile = array(
			"FULLNAME" => $fullName,
			"SEX" => $sex,
			"BIRTHDATE" => $dateOfBirth,
			"LINEONE" => $address1,
			"LINETWO" => $address2,
			"CITY" => $city,
			"COUNTRY" => $country,
			"STATE" => $state,
			"ZIPCODE" => $zipcode,
			"CARDNUMBER" => $ccNumber,
			"NAMEONCARD" => $ccName,
			"EXPIRATIONMONTH" => $ccExpirationMonth,
			"EXPIRATIONYEAR" => $ccExpirationYear,
			"SECURITYCODE" => $ccSecurityCode,
			"SUBSCRIBENEWS" => $subscribe == 'on' ? 1 : 0
	);
	
	if ($oldPassword !== '' && $newPassword !== '')
		$profile['PASSWORD'] = $newPassword;
	
	Security::saveProfile($profile);
}

include_once framework::redirect("store/profile");