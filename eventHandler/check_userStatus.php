<?php

require '../config.php';
session_start();
DatabaseHandler::connect();

header("Content-Type: application/json");

global $translator;

$values_set = true;
if(!isset($_GET['checkWhat'])) $values_set = false;
if(!isset($_GET['toCheck'])) $values_set = false;

if($values_set == true)
{
	$checkWhat = $_GET['checkWhat'];
	$toCheck = DatabaseHandler::escape_string($_GET['toCheck']);

	if($checkWhat == 'usernameFree')
	{
		$free = 'true';
		foreach(DatabaseHandler::getAllUsers() as $user)
		{
			if(strcasecmp($user->getUsername(), $toCheck) == 0)
			{
				$free = 'false';
				break;
			}
		}
		echo '{"free":"' . $free . '","errormsg":"' . $translator->getString('usernametaken') . '"}';
	}
	else if($checkWhat == 'emailFree')
	{
		$free = 'true';
		foreach(DatabaseHandler::getAllUsers() as $user)
		{
			if(strcasecmp($user->getEmail(), $toCheck) == 0)
			{
				$free = 'false';
				break;
			}
		}
		echo '{"free":"' . $free . '","errormsg":"' . $translator->getString('emailtaken') . '"}';
	}
}


DatabaseHandler::close();