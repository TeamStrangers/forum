<?php

session_start();

define('PAGENAME', "title_home");

require 'config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);



$page = 'Tere';


PageDrawer::drawPage($page);

DatabaseHandler::close();