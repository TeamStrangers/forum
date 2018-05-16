<?php

require '../config.php';
session_start();
DatabaseHandler::connect();

$values_set = true;
if(!(isset($_POST['username']) && !empty($_POST['username']))) $values_set = false;
if(!(isset($_POST['password']) && !empty($_POST['password']))) $values_set = false;

$translator = new Translator($_SESSION['language']);

if($values_set == true)
{
	$username = DatabaseHandler::escape_string($_POST['username']);
	$password = hash('sha256', $salt . DatabaseHandler::escape_string($_POST['password']));

	$user_found = false;

	foreach(DatabaseHandler::getAllUsers() as $user)
	{
		if($user->getUsername() == $username || $user->getEmail() == $username)
		{
			$user_found = true;
			if($user->getPassword() == $password)
			{
				$_SESSION['sqlid'] = $user->getSQLID();
				$_SESSION['language'] = $user->getSiteLanguage();
				header("Location: " . SITE_URL . "/index.php?msg[0]=success&msg[1]=" . $translator->getString('loginsuccess'));
			}
			else
			{
				header("Location: " . SITE_URL . "/index.php?msg[0]=error&msg[1]=" . $translator->getString('incorrectpass'));
			}
			break;
		}
	}
	if($user_found == false)
	{
		header("Location: " . SITE_URL . "/index.php?msg[0]=error&msg[1]=" . $translator->getString('incorrectpass'));
	}
}

DatabaseHandler::close();

header("Location: " . SITE_URL . "/index.php?msg[0]=error&msg[1]=" . $translator->getString('unexpectederror'));