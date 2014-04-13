<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Items.php');
include_once framework::resolve('packages/store/model/Card.php');
include_once framework::resolve('packages/store/model/Packing.php');
include_once framework::resolve('packages/admin/model/Administration.php');

if (!Security::isSessionStartedByAdmin())
    if (Security::isSessionStarted()) die("Error: you have no privileges to open this page");
    else header("Location: " . framework::link_to('base/login', false) . "&returnTo=admin/dashboard");

$user = Security::getCurrentUser();
$isSessionStarted = true;
$title = "Dashboard";

$count_items = Items::getCountOfItems();
$count_cards = Card::getCountOfCards();
$count_bags = Packing::getCountOfBags();
$count_papers = Packing::getCountOfPapers();
$count_ornaments = Packing::getCountOfOrnaments();
$count_categories = Items::getCountOfCategories();
$count_cardmessages = Card::getCountOfCardMessages();

$languages = Security::getLanguages();
$i18n_progress = array();

$i18n_by_lists = array(
    "Items" => Items::getItemTranslationProgress(),
    "Bags" => Packing::getBagTranslationProgress(),
    "Papers" => Packing::getPaperTranslationProgress(),
    "Ornaments" => Packing::getOrnamentTranslationProgress(),
    "Categories" => Items::getCategoryTranslationProgress()
);

// Calc the total
$global_total = 0;
$global_part = 0;

foreach ($i18n_by_lists as $i18n) {
    $global_total += $i18n['TOTAL'];
    $global_part += $i18n['PART'];
}

if ($global_total < 1)
    $i18n_global = 0;
else
    $i18n_global = number_format($global_part / $global_total * 100, 0);

// Global by lang
$global_by_lang = array();
foreach ($languages as $lang) {
    $temp = array(
        "Items" => Items::getItemTranslationProgress(null, $lang['CODE']),
        "Bags" => Packing::getBagTranslationProgress(null, $lang['CODE']),
        "Papers" => Packing::getPaperTranslationProgress(null, $lang['CODE']),
        "Ornaments" => Packing::getOrnamentTranslationProgress(null, $lang['CODE']),
        "Categories" => Items::getCategoryTranslationProgress(null, $lang['CODE'])
    );

    $global_by_lang[$lang['CODE']] = array('LABEL' => $lang['NAME'], 'PERCENT' => 0);

    $total = $temp['Items']['TOTAL'] +
            $temp['Bags']['TOTAL'] +
            $temp['Papers']['TOTAL'] +
            $temp['Ornaments']['TOTAL'] +
            $temp['Categories']['TOTAL'];

    $part = $temp['Items']['PART'] +
            $temp['Bags']['PART'] +
            $temp['Papers']['PART'] +
            $temp['Ornaments']['PART'] +
            $temp['Categories']['PART'];

    if ($total > 0)
        $global_by_lang[$lang['CODE']]['PERCENT'] = number_format($part / $total * 100, 0);
}

$images_stats = Administration::getImagesStats();

$i_f = count($images_stats['found']); // images in the db and file system
$i_nf = count($images_stats['not_found']); // images in the db and not in the file system
$i_nm = count($images_stats['not_match']); // images in the file system and not in the db
$i_db = $i_f + $i_nf; // total images in the db
$i_fs = $i_f + $i_nm; // total images in the filesystem

include_once framework::resolve('packages/admin/view/dashboard.tpl');
