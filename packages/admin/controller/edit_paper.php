<?php

include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');
include_once framework::resolve('packages/store/model/Codifiers.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$id = $_GET['id'];
$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];


$paper = Packing::getPaperById($id);

$texts = Packing::getPaperTexts($id);
$languages = Security::getLanguages();

$name = array();
$description = array();

foreach($languages as $lang){
    $name[$lang['CODE']] = "";
    $description[$lang['CODE']] = "";
}

if (is_array($texts)) foreach ($texts as $text) {
    $name[$text['LANGUAGE']] = $text['NAME'];
    $description[$text['LANGUAGE']] = $text['DESCRIPTION'];
}

$color1 = $paper['COLOR1'];
$color2 = $paper['COLOR2'];
$image1 = $paper['IMAGE'];
$occasion = $paper['OCCASION'];
$status = $paper['STATUS'];

$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$occasions = Codifiers::getOccasions();
$action = 'edit';
$title = "Edit paper";

include framework::resolve('packages/admin/view/form_paper.tpl');