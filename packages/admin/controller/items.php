<?php

/**
 * Show the items
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Items.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$title = "Items";
$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

if (is_null($current_lang))
    $items = Items::getItems(null, null, 'all');
else{
    $items = Items::getItemsWithoutTranslation(null, null, $current_lang);
    if (empty($items))
        framework::redirect("admin/items");
}
$languages = Security::getLanguages();
$i18n_lang_progress = array();

foreach ($languages as $langx) {
    $i18n_lang_progress[$langx['CODE']] = Items::getItemTranslationProgress(null, $langx['CODE']);
    $i18n_lang_progress[$langx['CODE']]['PERCENT'] = 100 - $i18n_lang_progress[$langx['CODE']]['PERCENT'];
}

include framework::resolve('packages/admin/view/items.tpl');