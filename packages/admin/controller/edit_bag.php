<?php

/**
 * Preparing a form for edit the bag
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/store/model/Packing.php');
include_once framework::resolve('packages/store/model/Codifiers.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

$languages = Security::getLanguages();
$id = $_GET['id'];
$bag = Packing::getBagById($id);
$texts = Packing::getBagTexts($id);

$current_lang = null;

if (isset($_GET['lang']))
    $current_lang = $_GET['lang'];

$name = array();
foreach ($languages as $lang) {
    $name[$lang['CODE']] = '';
}

if (is_array($texts)) foreach ($texts as $text) {
    $name[$text['LANGUAGE']] = $text['NAME'];
}

$width = $bag['WIDTH'];
$height = $bag['HEIGHT'];
$color1 = $bag['COLOR1'];
$color2 = $bag['COLOR2'];
$image1 = $bag['IMAGE1'];
$image2 = $bag['IMAGE2'];
$image3 = $bag['IMAGE3'];
$occasion = $bag['OCCASION'];
$base = $bag['BASE'];
$stock = $bag['STOCK'];
$status = $bag['STATUS'];
$user = Security::getCurrentUser();
$username = $user['FULLNAME'];
$occasions = Codifiers::getOccasions();
$action = 'edit';
$title = "Edit paper bag";

include framework::resolve('packages/admin/view/form_bag.tpl');