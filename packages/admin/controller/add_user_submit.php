<?php

include_once framework::resolve('packages/base/model/Security.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

foreach ($_POST as $key => $val) {
    $key = strtolower($key);
    $$key = $val;
}

$error = false;

if (trim($email) == '') {
    $error = "Email is required!";
    $errcode = 2;
} elseif ($password != $password2) {
    $error = "Password not match!";
    $errcode = 1;
}

if ($error !== false) {
    $shipping_methods = Security::getShippingMethods();
    $payment_methods = Security::getPaymentMethods();
    $languages = Security::getLanguages();
    $title = "Add a user";
    $user = Security::getCurrentUser();
    $username = $user['FULLNAME'];
    include framework::resolve('packages/admin/view/form_user.tpl');
} else {
    Security::addUser($email, $fullname, $language, $password, $sex, $birthdate);
    framework::redirect("admin/users");
}
