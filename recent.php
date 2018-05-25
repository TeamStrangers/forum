<?php

session_start();

define('PAGENAME', "title_mostrecent");

require 'config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);



$page = 'Recent';


PageDrawer::drawPage($page);

DatabaseHandler::close();