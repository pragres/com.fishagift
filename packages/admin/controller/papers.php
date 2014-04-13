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
    $papers = Packing::getPapers(null, null, 'all');
else {
    $papers = Packing::getPapersWithoutTranslation(null, null, $current_lang);
    if (empty($papers))
        framework::redirect("admin/papers");
}

$languages = Security::getLanguages();


$i18n_lang_progress = array();

foreach ($languages as $lang) {
    $i18n_lang_progress[$lang['CODE']] = Packing::getPaperTranslationProgress(null, $lang['CODE']);
    $i18n_lang_progress[$lang['CODE']]['PERCENT'] = 100 - $i18n_lang_progress[$lang['CODE']]['PERCENT'];
}

include framework::resolve('packages/admin/view/papers.tpl');
