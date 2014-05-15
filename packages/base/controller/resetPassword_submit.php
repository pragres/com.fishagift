<?php
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/email/model/Email.php');

$email = framework::getValue('emailReset');

$u = Security::getUser($email);

if (! is_null($u) && $u !== false) {
	
	$newPassword = uniqid();
	
	Security::updateUserInformation($email, array(
			'PASSWORD' => $newPassword
	));
	
	Email::sendNewPassword($email, $newPassword);
	framework::redirect("base/login");
} else {
	framework::redirect("base/login", "&error=emailNoExist");
}