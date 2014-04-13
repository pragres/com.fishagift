<?php

/**
 * List of card messages
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Card.php');
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Codifiers.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$cardmessages = Card::getCardMessages();
$r = Codifiers::getOccasions();

$occasions = array();
foreach ($r as $rr)
    $occasions[$rr['ID']] = $rr;

$languages = array();
$r = Security::getLanguages();
foreach ($r as $rr)
    $languages[$rr['CODE']] = $rr;

include framework::resolve('packages/admin/view/cardmessages.tpl');
