<?php
// Config global constant variable
$domain = $_SERVER["SERVER_NAME"];
if($_SERVER["SERVER_PORT"] != 80)
	$domain .= ":".$_SERVER["SERVER_PORT"];

session_start();
	
$relRoot = dirname($_SERVER['SCRIPT_NAME']);
if(substr($relRoot, -1) != "/") $relRoot .= "/"; 
define('RootURL', 'http://'.$domain.$relRoot);
define('RootABS', 'http://'.$domain.$relRoot);
define('RootREL', $relRoot);
define('UploadREL', 'media/upload/');
define('UploadURI', $relRoot.UploadREL);
define('RootURI', dirname($_SERVER['SCRIPT_FILENAME'])."/");
define('ControllerREL', 'controllers/');
// Config for database
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','Thanhdat328@');
define('DB_NAME','oopmvc1');

// Global variables
$app = [];
$app['area'] = 'users';
$app['areaPath'] = '';

$app['recordTime'] = [
	'created'	=>	'created',
	'updated'	=>	'updated'
];
$mediaFiles = [
	'css'	=>	[],
	'js'	=>	[]
];
$obMediaFiles = $mediaFiles;
//define('OB',true);

$enableOB = false;

?>