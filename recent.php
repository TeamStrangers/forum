<?php

session_start();

define('PAGENAME', "title_mostrecent");
define('THIS_SCRIPT', 'recent');

require 'config.php';

DatabaseHandler::connect();

$page = '';
global $current_user, $translator;




$i = 1;
$page .= '<div id="threads">';
foreach(DatabaseHandler::getThreadsByTime() as $thread)
{
	if($i > 25) break;

	$page .= '<a href="' . SITE_URL . '/view_thread.php?threadid=' . $thread->getSQLID() . '" class="thread">';
	$page .= '<div class="title">' . $thread->getName() . '</div>';
	$poster = DatabaseHandler::getUserBySQLID($thread->getCreatedBy());
	$page .= '<div class="poster">' . $translator->getString('postedby', array('poster' => $poster->getUsername())) . '</div>';
	$page .= '</a><br>';

	$i++;
}
$page .= '</div>';




PageDrawer::drawPage($page);

DatabaseHandler::close();