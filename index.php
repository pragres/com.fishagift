<?php 
// index.php
// Redirect to the proper server and page
// ==========================================================

$config = parse_ini_file("framework/config.ini", true, INI_SCANNER_NORMAL);
$protocol = $config['website']['protocol'];
$domain = $config['website']['appdomain'];

header("Location: $protocol://$domain/store/home");
