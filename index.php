<?php

define('PAGENAME', "Home");

require 'config.php';
session_start();
$_SESSION['language'] = 'et';
DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);



$page = 'Tere';


PageDrawer::drawPage($page);

DatabaseHandler::close();