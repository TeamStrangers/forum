<?php

session_start();

define('PAGENAME', "Home");

require 'config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);



$page = 'Tere';


PageDrawer::drawPage($page);

DatabaseHandler::close();