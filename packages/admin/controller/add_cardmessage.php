<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Codifiers.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$text = "";
$occasion = 0;
$language = '';
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$occasions = Codifiers::getOccasions();
$languages = Security::getLanguages();
$action = 'add';
$title = "New card message";

include framework::resolve('packages/admin/view/form_cardmessage.tpl');
