<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/admin/model/Administration.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$status = 'Pending';
$highlight = 0;

if (isset($_GET['status'])) $status = $_GET['status'];
if (isset($_GET['highlight'])) $highlight = $_GET['highlight'];

if ($status != 'Pending' && $status !='Cancelled' && $status !='Delivered') $status = 'Pending';

// passing variables to the view
$title = "$status orders";

$orders = Administration::getOrders($status);

// calling the view
include_once framework::resolve('packages/admin/view/orders.tpl');
