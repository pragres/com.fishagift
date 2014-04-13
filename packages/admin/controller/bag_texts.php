<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$id = $_GET['id'];

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

$texts = Packing::getBagTexts($id);
$missing = Packing::getMissingTranslationsOfBag($id);
$i18n_progress = Packing::getBagTranslationProgress($id);

include framework::resolve('packages/admin/view/bag_texts.tpl');
