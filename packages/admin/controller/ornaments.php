<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("base/login", "&returnTo=admin/ornaments");

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

if (is_null($current_lang))
    $ornaments = Packing::getOrnaments(null, null, 'all');
else {
    $ornaments = Packing::getOrnamentsWithoutTranslation(null, null, $current_lang);
    if (empty($ornaments))
        framework::redirect("admin/ornaments");
}

$languages = Security::getLanguages();
$i18n_lang_progress = array();

foreach ($languages as $langx) {
    $i18n_lang_progress[$langx['CODE']] = Packing::getOrnamentTranslationProgress(null, $langx['CODE']);
    $i18n_lang_progress[$langx['CODE']]['PERCENT'] = 100 - $i18n_lang_progress[$langx['CODE']]['PERCENT'];
}

include framework::resolve('packages/admin/view/ornaments.tpl');