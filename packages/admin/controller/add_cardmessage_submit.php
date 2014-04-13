<?php

include_once framework::resolve('packages/base/model/Security.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

include_once framework::resolve('packages/store/model/Card.php');

foreach ($_POST as $key => $val) {
    $key = strtolower($key);
    $$key = $val;
}

Card::addCardMessage($text, $occasion, $language);

framework::redirect("admin/cardmessages");
