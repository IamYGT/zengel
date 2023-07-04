<?php
// Error Reporting Turn On
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Setting up the time zone
date_default_timezone_set('Europe/Istanbul');

// Host Name
$dbhost = 'localhost';

// Database Name
$dbname = 'seyhanweb_qAa451';

// Database Username
$dbuser = 'seyhanweb_qAa451';

// Database Password
$dbpass = '?1Lky98m0';

// Defining base url
define("BASE_URL", "https://www.zengel.com.tr/");

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $ex ) {
    echo "Connection error :" . $ex->getMessage();
}