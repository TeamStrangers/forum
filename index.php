<?php

session_start();

define('PAGENAME', "title_home");
define('THIS_SCRIPT', 'index');

require 'config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);
$page = '';
global $current_user;




if($current_user != null)
{
	$followingCategories = DatabaseHandler::getCategoriesByList($current_user->getCategoriesFollowing());
	$page .= '<table>';
	$page .= '<tr>';
	$page .= '<th>Kategooria nimi</th>';
	$page .= '</tr>';
	foreach($followingCategories as $category)
	{
		$page .= '<tr>';
		$page .= '<td>' . $category->getName() . '</td>';
		$page .= '</tr>';
	}
	$page .= '</table>';
}
else
{
	$page .= 'Home';
}




PageDrawer::drawPage($page);

DatabaseHandler::close();