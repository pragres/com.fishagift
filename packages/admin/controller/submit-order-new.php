<?php

// TODO: Complete this
// including models
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/admin/model/Administration.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

// receiving varibales from the POST
$order['TRACKING'] = rand();
$order['SENDER'] = 'salvi.pascual@gmail.com';
$order['RECEIVER'] = MD5(microtime());
$order['RECEIVERADDRESS1'] = MD5(microtime());

// saving the new order
$getItemsByType = Administration::createNewOrder($order);
