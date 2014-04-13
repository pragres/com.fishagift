<?php

include_once framework::resolve('packages/store/model/Packing.php');

$occasion = null;
if (isset($_GET['occasion']))
    $occasion = $_GET['occasion'];


// adding to cart
include_once framework::resolve('packages/store/model/Card.php');
$language = framework::session_get("language");

echo Card::generateCardMessage($occasion, $language);