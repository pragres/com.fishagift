<?php
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/email/model/Email.php');

$email = framework::getValue('emailReset');

$u = Security::getUser($email);

if (! is_null($u) && $u !== false) {
	
	$newPassword = uniqid();
	
	Security::updateUserInformation($email, array(
			'password' => $newPassword
	));
	
	Email::sendNewPassword($email, $newPassword);
	framework::redirect("store/login");
} else {
	framework::redirect("store/login", "&error=emailNoExist");
}