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
			if($threads == 1) $subcategories .= '<div class="left">' . $threads . ' ' . $translator->getString('threads1') . '</div>';
			else $subcategories .= '<div class="left">' . $threads . ' ' . $translator->getString('threads2') . '</div>';
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
	//TODO: List all posts
}
else
{
	$page = 'Category not found';
}


PageDrawer::drawPage($page, $additions);

DatabaseHandler::close();