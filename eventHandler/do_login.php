<?php

require '../config.php';
session_start();
DatabaseHandler::connect();

$values_set = true;
if(!(isset($_POST['username']) && !empty($_POST['username']))) $values_set = false;
if(!(isset($_POST['password']) && !empty($_POST['password']))) $values_set = false;

$fromsite = SITE_URL . '/index.php';
if(isset($_POST['fromsite'])) $fromsite = $_POST['fromsite'];

$translator = new Translator($_SESSION['language']);

global $current_user;
if($values_set == true && $current_user == null)
{
	$username = DatabaseHandler::escape_string($_POST['username']);
	$password = hash('sha256', $salt . DatabaseHandler::escape_string($_POST['password']));

	$user_found = false;

	foreach(DatabaseHandler::getAllUsers() as $user)
	{
		if(strcasecmp($user->getUsername(), $username) == 0 || strcasecmp($user->getEmail(), $username) == 0)
		{
			$user_found = true;
			if(strcasecmp($user->getPassword(), $password) == 0)
			{
				$_SESSION['sqlid'] = $user->getSQLID();
				$_SESSION['language'] = $user->getSiteLanguage();
				header("Location: " . $fromsite . "?msg[0]=success&msg[1]=" . $translator->getString('loginsuccess', array('username' => $user->getUsername())));
				DatabaseHandler::close();
				exit();
			}
			else
			{
				header("Location: " . $fromsite . "?msg[0]=error&msg[1]=" . $translator->getString('incorrectpass'));
				DatabaseHandler::close();
				exit();
			}
			break;
		}
	}
	if($user_found == false)
	{
		header("Location: " . $fromsite . "?msg[0]=error&msg[1]=" . $translator->getString('incorrectpass'));
		DatabaseHandler::close();
		exit();
	}
}

DatabaseHandler::close();

header("Location: " . $fromsite . "?msg[0]=error&msg[1]=" . $translator->getString('unexpectederror'));