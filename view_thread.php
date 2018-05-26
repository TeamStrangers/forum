<?php

session_start();

define('PAGENAME', "title_viewthread");
define('THIS_SCRIPT', 'view_thread');

require 'config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);
$page = '';

$sqlid = (int) DatabaseHandler::escape_string($_GET['threadid']);
$thread = DatabaseHandler::getThreadBySQLID($sqlid, true);

if($thread != null)
{
	define('CUSTOM_TITLE', $translator->getString('title', array('pagename' => htmlspecialchars($thread->getName()))));

	$poster = DatabaseHandler::getUserBySQLID($thread->getCreatedBy());
	if($poster == null) { $poster = new User(null); }

	$page .= '<div id="mainThread">';

	$page .= '<div class="poster">';
	$page .= '<img class="avatar" src="' . $poster->getAvatar() . '">';
	$page .= '<span class="infofield"><a href="' . SITE_URL . '/userCP/view_profile.php?uid=' . $poster->getSQLID() . '">' . $poster->getUsername() . '</a></span>';
	$page .= '<span class="infofield" style="margin: 5px 0;">' . $poster->getRoleTxt() . '</span>';
	$page .= '<span class="infofield" style="margin: 10px 0; font-size: 0.8em;">' . htmlspecialchars($poster->getNationality()) . '</span>';
	$page .= '<span class="infofield"><span class="left">' . $translator->getString('joined') . '</span><span class="right">' . date("F j, Y", $poster->getJoindate()) . '</span></span><br>';
	$page .= '<span class="infofield"><span class="left">Threads posted:</span><span class="right">efgh</span></span><br>';
	$page .= '<span class="infofield"><span class="left">Posts made:</span><span class="right">efgh</span></span><br>';
	$page .= '</div>';

	$page .= '<div class="content"><span>' . nl2br(htmlspecialchars($thread->getName())) . '</span>' . nl2br(htmlspecialchars($thread->getContent())) . '</div>';
	$page .= '</div>';



	$page .= '<div id="posts">';
	foreach($thread->getPosts() as $post)
	{
		$poster2 = DatabaseHandler::getUserBySQLID($post->getCreatedBy());
		if($poster2 == null) { $poster2 = new User(null); }

		$page .= '<div class="post">';
		$page .= '<div class="poster">';
		$page .= '<img class="avatar" src="' . $poster2->getAvatar() . '">';
		$page .= '<span class="infofield"><a href="' . SITE_URL . '/userCP/view_profile.php?uid=' . $poster2->getSQLID() . '">' . $poster2->getUsername() . '</a></span>';
		$page .= '<span class="infofield" style="margin: 5px 0;">' . $poster2->getRoleTxt() . '</span>';
		$page .= '</div>';
		$page .= '<div class="content">' . nl2br(htmlspecialchars($post->getContent())) . '</div></div>';

	}
	$page .= '</div>';
}
else
{
	$page = 'Thread not found';
}


PageDrawer::drawPage($page);

DatabaseHandler::close();