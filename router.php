<?php

// router.php
// This file will redirect the requests to the proper server
// and page, and execute global inclusions
// ==========================================================

/**
 * displaying or hiding PHP errors
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Force to load the website securely on production
 * domain name and port hardcoded for efficiency
 */
if($_SERVER['HTTP_HOST']=="fishagift.com" && $_SERVER['SERVER_PORT']=="80"){
	header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
	exit();
}

/**
 * defining non-obstructing headers
 */
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/New_York');

/**
 * includes and inicializes framework functionality
 */
include_once "framework/session.php";
include_once "framework/framework.php";
include_once "framework/Tracer.php";
include_once "framework/Error.php";

framework::$config = parse_ini_file("framework/config.ini", true, INI_SCANNER_NORMAL); // INI_SCANNER_RAW

/**
 * starting the global session
 * NOTE: if you don't want to store session in the database,
 * change "session::session_start();" by "session_start();"
 */
session_start();

$lang = framework::session_get("language");

if (! $lang || is_null($lang))
	framework::session_set("language", "en");

/**
 * update the Tracer structure
 */
Tracer::createTrace();

/**
 * redirect errors to the admin's email
 */
set_error_handler('Error::errorHandler'); // Set the error handler
register_shutdown_function('Error::notifyErrors'); // Register shutdown functions

/**
 * obtaining the page to load and throwing
 * error 404 if the page does not exist
 */
$package = $_REQUEST['package'];
$page = $_REQUEST['page'];
$path = "packages/$package/controller/$page.php";

if (! file_exists($path)) {
	header("HTTP/1.0 404 Not Found");
	include_once framework::resolve('packages/base/view/error404.tpl');
	exit();
}

/**
 * loading webpage
 */
include $path;