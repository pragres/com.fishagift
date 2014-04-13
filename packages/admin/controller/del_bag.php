<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

$id = $_GET['id'];
Packing::delBag($id);

framework::redirect("admin/bags", is_null($current_lang) ? '' : '&lang=' . $current_lang);