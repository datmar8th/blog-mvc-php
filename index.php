<?php

include_once('config/main.php');
include_once("config/autoload.php");
// $slug = isset($_GET['slug']) ? $_GET['slug'] : null;
$cn = isset($_GET["ctl"])? $_GET["ctl"]: "home";
if(!is_file('controllers/'.$cn.'_controller.php')) 	$cn = 'staticpages';
$c = $cn."_controller";
$controller = new $c();
// $controller->setSlug($slug);

// ini_set('display_errors', 1); 
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// include_once(__DIR__.'/config/main.php');
// include_once(__DIR__.'/config/autoload.php');
// include_once(__DIR__.'/config/app.php');
?>