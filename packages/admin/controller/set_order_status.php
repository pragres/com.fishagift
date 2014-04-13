<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/admin/model/Administration.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$status = 'Pending';

if (isset($_GET['status']))
    $status = $_GET['status'];

if ($status != 'Pending' && $status != 'Cancelled' && $status != 'Delivered')
    $status = 'Pending';

$transaction = $_GET['transaction'];

Administration::setOrderStatus($transaction, $status);

framework::redirect("admin/orders", "&status=$status&highlight=$transaction");