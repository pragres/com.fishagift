<?php

include_once framework::resolve('packages/base/model/Security.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$email = $_GET['email'];
$user = Security::getUser($email);
$user['ADMINISTRATOR'] = 1;
Security::updateUserInformation($email, $user);

framework::redirect("admin/users");
