<?php
// Start Session
if (!isset($_SESSION)) {
  session_start();
}

// Create and initialize variables
$errors = array();

// Define paths
define("DS", DIRECTORY_SEPARATOR);
define("ROOT_DIRECTORY", dirname(dirname(dirname(__FILE__))).DS);

// Require resources
require_once ROOT_DIRECTORY . "assets/core/db/connect.php";
require_once ROOT_DIRECTORY . "assets/core/load_classes.php";
require_once ROOT_DIRECTORY . "assets/core/functions.php";

// Create instance/object of classes
$contact = new Contact();

$session = new Session();

$user = new User();
$profile = new Profile();


$system = new System();

// Fetch page url
$page = basename($_SERVER['PHP_SELF']);
