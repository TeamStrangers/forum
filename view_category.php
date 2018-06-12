<?php

session_start();

define('PAGENAME', "title_viewthread");
define('THIS_SCRIPT', 'view_category');

require 'config.php';

DatabaseHandler::connect();

global $translator;

$page = '';
$additions = array();

$categories = DatabaseHandler::getCategories();

$sqlid = (int) DatabaseHandler::escape_string($_GET['category']);
$category = null;

foreach($categories as $cat)
{
	if($cat->getSQLID() == $sqlid)
	{
		$category = $cat;
		break;
	}
}

if($category != null)
{
	$additions['custom_menu0'] = array();
	$additions['custom_menu0'][$translator->getString('post_control_new')] = '/new_thread.php?action=thread&subid=' . $category->getSQLID();

	$page .= '<div class="categoryTree">' . CategoryManager::generateCategoryTree($category) . '</div>';

	//Show all subcategories
	$subcategories = '';
	$subcategoriesCount = 0;

	$subcategories .= '<div class="subcategories">';
	$subcategories .= '<div class="title">' . $translator->getString('subcategories') . '</div>';
	$subcategories .= '<div class="container">';
	foreach($categories as $cat)
	{
		if($cat->getParent() == $category->getSQLID())
		{
			$subcategories .= '<a href="view_category.php?category=' . $cat->getSQLID() . '" class="subcategory">';
			$subcategories .= '<div class="title">' . $cat->getName() . '</div>';
			$subcategories .= '<div class="categorystats">';
			$threads = CategoryManager::countThreads($cat);
			if($threads == 1) $subcategories .= '<div class="left">' . $translator->getString('threads1', array("threadcount" => $threads)) . '</div>';
			else $subcategories .= '<div class="left">' . $translator->getString('threads2', array("threadcount" => $threads)) . '</div>';
			//$subcategories .= '<div class="right">' . CategoryManager::countPosts($cat) . '</div>';
			$subcategories .= '</div>';
			$subcategories .= '</a>';
			$subcategoriesCount++;
		}
	}
	$subcategories .= '</div>';
	$subcategories .= '</div>';

	if($subcategoriesCount > 0)
	{
		$page .= $subcategories;
	}

	//List all posts
	$page .= '<div class="subcategories">';
	$page .= '<div class="title">' . $translator->getString('threads3') . '</div>';
	$page .= '<div class="container">';

	$threadcount = 0;

	$threads = DatabaseHandler::getThreadsByCategory($category->getSQLID(), true);
	foreach($threads as $thread)
	{
		$threadcount++;

		$page .= '<a class="subcategory" href="' . SITE_URL . '/view_thread.php?threadid=' . $thread->getSQLID() . '">';
		$page .= '<div class="title">' . $thread->getName() . '</div>';
		$page .= '<div class="categorystats">';
		$poster = DatabaseHandler::getUserBySQLID($thread->getCreatedBy());
		$page .= '<div class="left">' . $translator->getString('postedby', array('poster' => $poster->getUsername())) . '</div>';
		$replies = count($thread->getPosts());
		if($replies == 1) $page .= '<div class="right">' . $translator->getString('replycount1', array('count' => $replies)) . '</div>';
		else $page .= '<div class="right">' . $translator->getString('replycount2', array('count' => $replies)) . '</div>';
		$page .= '</div>';
		$page .= '</a>';
	}

	if($threadcount == 0)
	{
		$page .= '<div class="nothreads">' . $translator->getString('threads4') . '</div>';
	}

	$page .= '</div>';
	$page .= '</div>';
}
else
{
	$page = 'Category not found';
}


PageDrawer::drawPage($page, $additions);

DatabaseHandler::close();