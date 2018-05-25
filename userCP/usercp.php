<?php

session_start();

define('PAGENAME', "account_settings");

require '../config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);



$page = 'UserCP';


PageDrawer::drawPage($page);

DatabaseHandler::close();