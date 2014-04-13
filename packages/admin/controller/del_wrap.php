<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$id = $_GET['id'];

Packing::deleteWrappingPaperById($id);

framework::redirect("admin/wraps");