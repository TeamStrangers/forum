<?php

session_start();

define('PAGENAME', "title_home");
define('THIS_SCRIPT', 'index');

require 'config.php';

DatabaseHandler::connect();

$page = '';
global $current_user, $translator;


$categories = DatabaseHandler::getCategories();
foreach($categories as $category)
{
	if($category->getParent() == '')
	{
		$page .= '<div class="basecategory">';
		$page .= '<div class="title">' . $category->getName() . '</div>';
		$page .= '<div class="container">';

		foreach($categories as $subcateroy)
		{
			if($subcateroy->getParent() == $category->getSQLID())
			{
				$page .= '<a href="view_category.php?category=' . $subcateroy->getSQLID() . '" class="category">';
				$page .= '<div class="title">' . $subcateroy->getName() . '</div>';
				$page .= '<div class="categorystats">';
				$threads = CategoryManager::countThreads($subcateroy);
				if($threads == 1) $page .= '<div class="left">' . $translator->getString('threads1', array("threadcount" => $threads)) . '</div>';
				else $page .= '<div class="left">' . $translator->getString('threads2', array("threadcount" => $threads)) . '</div>';
				//$page .= '<div class="right">' . CategoryManager::countPosts($subcateroy) . '</div>';
				$page .= '</div>';
				$page .= '</a>';
			}
		}

		$page .= '</div>';
		$page .= '</div>';
	}
}




PageDrawer::drawPage($page);

DatabaseHandler::close();