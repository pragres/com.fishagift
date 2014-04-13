<?php

include_once framework::resolve('packages/base/model/Security.php');

if (!isset($_GET['email'])) framework::redirect("admin/users");

$email = $_GET['email'];

if (!Security::isSessionStartedByAdmin()){
    framework::redirect("base/login", "&returnTo=admin/dashboard");
}

$u = Security::getUser($email);
$fullName = $u['FULLNAME'];
$sex = $u['SEX'];
$birthdate = $u['BIRTHDATE'];
$language = $u['LANGUAGE'];
$password = $u['PASSWORD'];
$password2 = $u['PASSWORD'];
$languages = Security::getLanguages();

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$action = "edit_user";
$form_title = "Edit user $email";

include framework::resolve('packages/admin/view/form_user.tpl');
