<?php
include_once framework::resolve('packages/base/model/Security.php');

if (! Security::isSessionStartedByAdmin())
	framework::redirect("admin/home");

include_once framework::resolve('packages/admin/model/Administration.php');

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

$transaction = $_GET['transaction'];

if (isset($_POST['trackingNumber'])) {
	Administration::setTrackingNumber($transaction, $_POST['trackingNumber']);
	framework::redirect("admin/orders");
}

$order = Administration::getOrderDetails($transaction);

include framework::resolve('packages/admin/view/order.tpl');
