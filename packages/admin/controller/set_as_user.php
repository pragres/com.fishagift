<?php
include_once framework::resolve('packages/base/model/Security.php');

if (! Security::isSessionStartedByAdmin())
	framework::redirect("admin/home");

$user = Security::getUser($_GET['email']);

$user['ADMINISTRATOR'] = 0;

Security::updateUserInformation($_GET['email'], array(
		'ADMINISTRATOR' => 0
));

framework::redirect("admin/users");
