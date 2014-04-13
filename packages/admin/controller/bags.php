<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

if (is_null($current_lang))
    $bags = Packing::getBags(null, null, 'all');
else {
    $bags = Packing::getBagsWithoutTranslation(null, null, $current_lang);
    if (empty($bags))
        framework::redirect("admin/bags");
}
$languages = Security::getLanguages();

$i18n_lang_progress = array();

foreach ($languages as $lang) {
    $i18n_lang_progress[$lang['CODE']] = Packing::getBagTranslationProgress(null, $lang['CODE']);
    $i18n_lang_progress[$lang['CODE']]['PERCENT'] = 100 - $i18n_lang_progress[$lang['CODE']]['PERCENT'];
}

include framework::resolve('packages/admin/view/bags.tpl');
