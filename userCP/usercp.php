<?php

session_start();

define('PAGENAME', "account_settings");
define('THIS_SCRIPT', 'usercp');

require '../config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);



$page = 'UserCP';


PageDrawer::drawPage($page);

DatabaseHandler::close();