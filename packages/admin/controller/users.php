<?php

include_once framework::resolve('packages/base/model/Security.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

// passing variables to the view
$title = "Users";
$users = Security::getUsers();
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

// calling the view
include_once framework::resolve('packages/admin/view/users.tpl');
