<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Card.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

foreach ($_POST as $key => $val) {
    $key = strtolower($key);
    $$key = $val;
}

$id = $_GET['id'];
$cardmessage = Card::getCardMessageById($id);
$cardmessage['TEXT'] = $text;
$cardmessage['OCCASION'] = $occasion;
$cardmessage['LANGUAGE'] = $language;

Card::setCardMessage($id, $cardmessage);

framework::redirect("admin/cardmessages");
