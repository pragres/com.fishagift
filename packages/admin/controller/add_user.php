<?php

include_once framework::resolve('packages/base/model/Security.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$fullName = "";
$email = "";
$sex = "";
$birthdate = "";
$language = "";
$password = '';
$password2 = '';
$languages = Security::getLanguages();

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$action = "add_user";
$form_title = "Add a user";

include framework::resolve('packages/admin/view/form_user.tpl');
