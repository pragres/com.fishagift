<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Items.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("base/login", "&returnTo=admin/categories");

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];

if (is_null($current_lang))
    $categories = Items::getCategories(null, null, 'all');
else {
    $categories = Items::getCategoriesWithoutTranslation(null, null, $current_lang);
    if (empty($categories))
        framework::redirect("admin/categories");
}

$languages = Security::getLanguages();
$i18n_lang_progress = array();

foreach ($languages as $langx) {
    $i18n_lang_progress[$langx['CODE']] = Items::getCategoryTranslationProgress(null, $langx['CODE']);
    $i18n_lang_progress[$langx['CODE']]['PERCENT'] = 100 - $i18n_lang_progress[$langx['CODE']]['PERCENT'];
}


include framework::resolve('packages/admin/view/categories.tpl');

