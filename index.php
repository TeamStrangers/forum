<?php

session_start();

define('PAGENAME', "title_home");

require 'config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);



$page = 'Home';


PageDrawer::drawPage($page);

DatabaseHandler::close();