<?php

ini_set('display_errors', '1');

if(!isset($_SESSION['language'])) $_SESSION['language'] = 'en';
$valid_languages = array('en', 'et');

if(!defined('SITE_URL')) define('SITE_URL', '/forum'); //NO TRAILING SLASH!
if(!defined('CDN_URL')) define('CDN_URL', '/forum/cdn'); //NO TRAILING SLASH!

if(!defined('SITE_LOCATION')) define('SITE_LOCATION', $_SERVER['DOCUMENT_ROOT'] . SITE_URL);

require_once SITE_LOCATION . '/functionClasses/PageDrawer.php';
require_once SITE_LOCATION . '/functionClasses/DatabaseHandler.php';
require_once SITE_LOCATION . '/translations/Translator.php';
require_once SITE_LOCATION . '/models/User.php';

$mysql['hostname'] = 'localhost';
$mysql['username'] = 'discussr';
$mysql['password'] = 'discussr';
$mysql['database'] = 'discussr';
$mysql['dbprefix'] = 'discussr_';

$salt = 'laumdfhads';
