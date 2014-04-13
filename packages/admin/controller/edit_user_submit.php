<?php

include_once framework::resolve('packages/base/model/Security.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$id = $_GET['email'];

foreach ($_POST as $key => $val) {
    $key = strtolower($key);
    $$key = $val;
}

$orig =  Security::getUser($id);

$u = array();
$u['EMAIL'] = $email;
$u['FULLNAME'] = $fullname;
$u['SEX'] = $sex;
$u['BIRTHDATE'] = $birthdate;
$u['LANGUAGE'] = $language;
$u['PASSWORD'] = $password;

$data = array();

foreach ($u as $key => $value)
    if ($orig[$key] != $u[$key])
        $data[$key] = $value;

Security::updateUserInformation($id, $data);

framework::redirect("admin/users");