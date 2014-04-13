<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Card.php');
include_once framework::resolve('packages/store/model/Codifiers.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$id = $_GET['id'];
$cardmessage = Card::getCardMessageById($id);

$text = $cardmessage['TEXT'];
$occasion = $cardmessage['OCCASION'];
$language = $cardmessage['LANGUAGE'];
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$occasions = Codifiers::getOccasions();
$languages = Security::getLanguages();
$action = 'edit';
$title = "Edit card message";

include framework::resolve('packages/admin/view/form_cardmessage.tpl');
