<?php

session_start();

define('PAGENAME', "title_newthread");
define('THIS_SCRIPT', 'new_thread');

require 'config.php';

DatabaseHandler::connect();

global $current_user, $translator;
$page = '';
$additions = array();

$subid = null;
$action = null;
if(isset($_GET['subid'])) $subid = (int) DatabaseHandler::escape_string($_GET['subid']);
if(isset($_GET['action'])) $action = DatabaseHandler::escape_string($_GET['action']);

if($current_user != null)
{
	if($action == 'thread' && $subid != null)
	{
		$category = null;
		foreach(DatabaseHandler::getCategories() as $cat)
		{
			if($cat->getSQLID() == $subid)
			{
				$category = $cat;
				break;
			}
		}

		if($category != null)
		{
			if(isset($_POST['name']) && isset($_POST['content']) && !empty($_POST['name']) && !empty($_POST['content']))
			{
				$name = htmlspecialchars(DatabaseHandler::escape_string($_POST['name']));
				$content = htmlspecialchars(DatabaseHandler::escape_string($_POST['content']));

				$threadid = DatabaseHandler::createThread($category->getSQLID(), $current_user->getSQLID(), $name, $content);
				header("Location: " . SITE_URL . "/view_thread.php?threadid=" . $threadid);
			}
			else
			{
				define('CUSTOM_TITLE', $translator->getString('title_newthread'));

				$page .= '<div class="categoryTree">' . CategoryManager::generateCategoryTree($category, null, true) . '</div>';

				$page .= '<h1 class="thread_newthread">' . $translator->getString('thread_newthread', array('catname' => $category->getName())) . '</h1>';
				$page .= '<form class="global_pageForm" method="post" action="' . SITE_URL . '/new_thread.php?action=thread&subid=' . $subid . '">';
				$page .= '<input type="text" name="name" placeholder="' . $translator->getString('thread_name') . '"><br>';
				$page .= '<textarea name="content" placeholder="' . $translator->getString('thread_content') . '" rows="10"></textarea><br>';
				$page .= '<input type="submit" value="' . $translator->getString('thread_post') . '"><br>';
				$page .= '</form>';
			}
		}
	}
	else if($action == 'reply' && $subid != null)
	{
		$thread = null;
		foreach(DatabaseHandler::getThreads() as $thr)
		{
			if($thr->getSQLID() == $subid)
			{
				$thread = $thr;
				break;
			}
		}

		if($thread != null)
		{
			if(isset($_POST['content']) && !empty($_POST['content']))
			{
				$content = htmlspecialchars(DatabaseHandler::escape_string($_POST['content']));

				$postid = DatabaseHandler::createPost($thread->getSQLID(), $current_user->getSQLID(), $content);
				header("Location: " . SITE_URL . "/view_thread.php?threadid=" . $thread->getSQLID());
			}
			else
			{
				define('CUSTOM_TITLE', $translator->getString('title_newpost'));

				$page .= '<div class="categoryTree">' . CategoryManager::generateCategoryTree(DatabaseHandler::getThreadCategory($thread), $thread, null, null, true) . '</div>';

				$page .= '<form class="global_pageForm" method="post" action="' . SITE_URL . '/new_thread.php?action=reply&subid=' . $subid . '">';
				$page .= '<textarea name="content" placeholder="' . $translator->getString('post_content') . '" rows="10"></textarea><br>';
				$page .= '<input type="submit" value="' . $translator->getString('post_post') . '"><br>';
				$page .= '</form>';
			}
		}
	}
}




PageDrawer::drawPage($page, $additions);

DatabaseHandler::close();