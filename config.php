<?php

ini_set('display_errors', '1');

if(!isset($_SESSION['language'])) $_SESSION['language'] = 'en';
$valid_languages = array('en', 'et');

if(!defined('SITE_URL')) define('SITE_URL', ''); //NO TRAILING SLASH!
if(!defined('CDN_URL')) define('CDN_URL', '/cdn'); //NO TRAILING SLASH!

if(!defined('SITE_LOCATION')) define('SITE_LOCATION', $_SERVER['DOCUMENT_ROOT'] . SITE_URL);

require_once SITE_LOCATION . '/translations/Translator.php';
global $translator;
$translator = new Translator($_SESSION['language']);

require_once SITE_LOCATION . '/functionClasses/PageDrawer.php';
require_once SITE_LOCATION . '/functionClasses/DatabaseHandler.php';
require_once SITE_LOCATION . '/models/User.php';
require_once SITE_LOCATION . '/models/Categorie.php';
require_once SITE_LOCATION . '/models/Thread.php';
require_once SITE_LOCATION . '/models/Post.php';

global $mysql;
$mysql['hostname'] = 'localhost';
$mysql['username'] = 'discussr';
$mysql['password'] = 'discussr';
$mysql['database'] = 'discussr';
$mysql['dbprefix'] = 'discussr_';

$salt = 'laumdfhads';
