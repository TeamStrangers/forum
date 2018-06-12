<?php

class CategoryManager
{
	static function generateCategoryTree($category)
	{
		require SITE_LOCATION.'/config.php';
		$tree = array();
		array_push($tree, '<div class="treeItem"><a href="' . SITE_URL . '/view_category.php?category=' . $category->getSQLID() . '">' . $category->getName() . '</a></div>');

		$hasCategory = true;
		$parent = $category;

		while($hasCategory)
		{
			$parent = self::getParentCategory($parent);
			if($parent == null) { $hasCategory = false; break; }

			array_push($tree, '<div class="treeItem"><a href="' . SITE_URL . '/view_category.php?category=' . $parent->getSQLID() . '">' . $parent->getName() . '</a></div>');
		}
		$tree = array_reverse($tree);

		$realTree = '';
		foreach($tree as $treeItem)
		{
			$realTree .= $treeItem;
		}
		return $realTree;
	}

	static function getParentCategory($category)
	{
		require SITE_LOCATION.'/config.php';
		foreach(DatabaseHandler::getCategories() as $cat)
		{
			if($category->getParent() == $cat->getSQLID())
			{
				return $cat;
			}
		}
		return null;
	}

	static function getChildrenCategories($category)
	{
		$categories = array();
		foreach(DatabaseHandler::getCategories() as $cat)
		{
			if($cat->getParent() == $category->getSQLID())
			{
				array_push($categories, $cat);
			}
		}
		return $categories;
	}

	static function countThreads($category)
	{
		$threads = 0;
		$categories = self::getChildrenCategories($category);
		for($i = 0; $i <= 10; $i++)
		{
			$old_categories = $categories;
			foreach($categories as $cat)
			{
				$childCats = self::getChildrenCategories($cat);
				foreach($childCats as $caaat)
				{
					array_push($categories, $caaat);
				}
			}
			if($old_categories == $categories) break;
		}

		$cats = array();
		array_push($cats, $category->getSQLID());
		foreach($categories as $cat)
		{
			array_push($cats, $cat->getSQLID());
		}

		foreach(DatabaseHandler::getThreads() as $thread)
		{
			if(in_array($thread->getCategorie(), $cats))
			{
				$threads++;
			}
		}

		return $threads;
	}

	static function countPosts($category)
	{
		$posts = 0;
		$categories = self::getChildrenCategories($category);
		for($i = 0; $i <= 10; $i++)
		{
			$old_categories = $categories;
			foreach($categories as $cat)
			{
				$childCats = self::getChildrenCategories($cat);
				foreach($childCats as $caaat)
				{
					array_push($categories, $caaat);
				}
			}
			if($old_categories == $categories) break;
		}

		$cats = array();
		array_push($cats, $category->getSQLID());
		foreach($categories as $cat)
		{
			array_push($cats, $cat->getSQLID());
		}

		foreach(DatabaseHandler::getThreads() as $thread)
		{
			if(in_array($thread->getCategorie(), $cats))
			{
				$posts++;
			}
		}

		return $posts;
	}
}