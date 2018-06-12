<?php

session_start();

define('PAGENAME', "title_viewthread");
define('THIS_SCRIPT', 'view_thread');

require 'config.php';

DatabaseHandler::connect();

global $translator;
$page = '';
$additions = array();

$subid = null;
$action = null;
if(isset($_GET['subid'])) $subid = (int) DatabaseHandler::escape_string($_GET['subid']);
if(isset($_GET['action'])) $action = DatabaseHandler::escape_string($_GET['action']);

if($action == 'thread' && $subid != null)
{
}
else if($action == 'reply' && $subid != null)
{
}

/*$category = null;
if(isset($_GET['subid']))
{
	$sqlid = (int) DatabaseHandler::escape_string($_GET['subid']);
	foreach(DatabaseHandler::getCategories() as $cat)
	{
		if($cat->getSQLID() == $sqlid)
		{
			$category = $cat;
			break;
		}
	}
}

if($category != null)
{
}*/




PageDrawer::drawPage($page, $additions);

DatabaseHandler::close();