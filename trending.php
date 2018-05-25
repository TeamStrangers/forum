<?php

session_start();

define('PAGENAME', "title_trending");

require 'config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);



$page = 'Trending';


PageDrawer::drawPage($page);

DatabaseHandler::close();