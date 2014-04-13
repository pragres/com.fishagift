<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Card.php');

if (!Security::isSessionStartedByAdmin())
   framework::redirect("base/login", "&returnTo=admin/cards");

$cards = Card::getCards();
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

include framework::resolve('packages/admin/view/cards.tpl');
