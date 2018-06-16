<?php

session_start();

define('PAGENAME', "title_viewthread");
define('THIS_SCRIPT', 'view_thread');

require 'config.php';

DatabaseHandler::connect();

global $current_user, $translator;
$page = '';
$additions = array();

$threadid = null;
$action = null;
if(isset($_GET['threadid'])) $threadid = (int) DatabaseHandler::escape_string($_GET['threadid']);
if(isset($_GET['action'])) $action = DatabaseHandler::escape_string($_GET['action']);

if($action == 'edit' && $threadid != null)
{
	$thread = DatabaseHandler::getThreadBySQLID($threadid);
	if($current_user->getSQLID() == $thread->getCreatedBy() || $current_user->getRole() == 3 || $current_user->getRole() == 4) //Creator, moderator or administrator
	{
		if(isset($_POST['name']) && isset($_POST['content']) && !empty($_POST['name']) && !empty($_POST['content']))
		{
			$name = htmlspecialchars(DatabaseHandler::escape_string($_POST['name']));
			$content = htmlspecialchars(DatabaseHandler::escape_string($_POST['content']));

			$thread->setName($name);
			$thread->setContent($content);

			DatabaseHandler::saveThread($thread);

			header("Location: " . SITE_URL . "/view_thread.php?threadid=" . $threadid);
		}
		else
		{
			define('CUSTOM_TITLE', $translator->getString('title_editthread'));

			$page .= '<div class="categoryTree">' . CategoryManager::generateCategoryTree(DatabaseHandler::getThreadCategory($thread), $thread, null, true) . '</div>';

			$page .= '<form class="global_pageForm" method="post" action="' . SITE_URL . '/edit_thread.php?action=edit&threadid=' . $threadid . '">';
			$page .= '<input type="text" name="name" placeholder="' . $translator->getString('thread_name') . '" value="' . $thread->getName() . '"><br>';
			$page .= '<textarea name="content" placeholder="' . $translator->getString('thread_content') . '" rows="10">' . $thread->getContent() . '</textarea><br>';
			$page .= '<input type="submit" value="' . $translator->getString('thread_save') . '"><br>';
			$page .= '</form>';
		}
	}
}
else if($action == 'delete' && $threadid != null)
{
	$thread = DatabaseHandler::getThreadBySQLID($threadid);
	if($current_user->getSQLID() == $thread->getCreatedBy() || $current_user->getRole() == 3 || $current_user->getRole() == 4) //Creator, moderator or administrator
	{
		header("Location: " . SITE_URL . "/view_category.php?category=" . DatabaseHandler::getThreadCategory($thread)->getSQLID());
		DatabaseHandler::deleteThread($thread);
	}
}
else if($action == 'deletepost' && $threadid != null)
{
	$post = DatabaseHandler::getPostBySQLID($threadid);
	if($current_user->getSQLID() == $post->getCreatedBy() || $current_user->getRole() == 3 || $current_user->getRole() == 4) //Creator, moderator or administrator
	{
		header("Location: " . SITE_URL . "/view_thread.php?threadid=" . $post->getThread());
		DatabaseHandler::deletePost($post);
	}
}




PageDrawer::drawPage($page, $additions);

DatabaseHandler::close();