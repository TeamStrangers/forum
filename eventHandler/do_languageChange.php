<?php

require '../config.php';
session_start();
DatabaseHandler::connect();

$values_set = true;
if(!(isset($_GET['language']) && !empty($_GET['language']))) $values_set = false;

if($values_set == true)
{
	$language = DatabaseHandler::escape_string($_GET['language']);
	if(in_array($language, $valid_languages))
	{
		$_SESSION['language'] = $language;
		global $current_user;
		if($current_user != null)
		{
			DatabaseHandler::updateLanguage($current_user, $language);
		}
	}
}

DatabaseHandler::close();