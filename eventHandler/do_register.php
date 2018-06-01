<?php

require '../config.php';
session_start();
DatabaseHandler::connect();

$values_set = true;
if(!(isset($_POST['username']) && !empty($_POST['username']))) $values_set = false;
if(!(isset($_POST['email']) && !empty($_POST['email']))) $values_set = false;
if(!(isset($_POST['password']) && !empty($_POST['password']))) $values_set = false;
if(!(isset($_POST['password2']) && !empty($_POST['password2']))) $values_set = false;

$fromsite = SITE_URL . '/index.php';
if(isset($_POST['fromsite'])) $fromsite = $_POST['fromsite'];

$translator = new Translator($_SESSION['language']);

global $current_user;
if($values_set == true && $current_user == null)
{
	$username = DatabaseHandler::escape_string($_POST['username']);
	$email = DatabaseHandler::escape_string($_POST['email']);
	$password = hash('sha256', $salt . DatabaseHandler::escape_string($_POST['password']));
	$password2 = hash('sha256', $salt . DatabaseHandler::escape_string($_POST['password2']));

	$usernameFree = true;
	$emailFree = true;
	foreach(DatabaseHandler::getAllUsers() as $user)
	{
		if(strcasecmp($user->getUsername(), $username) == 0)
		{
			$usernameFree = false;
		}

		if(strcasecmp($user->getEmail(), $email) == 0)
		{
			$emailFree = false;
		}
	}

	if($usernameFree)
	{
		if($emailFree)
		{
			if(strcasecmp($password, $password2) == 0)
			{
				$_SESSION['sqlid'] = DatabaseHandler::createUser($username, $email, $password);
				header("Location: " . $fromsite);
				DatabaseHandler::close();
				exit();
			}
			else
			{
				header("Location: " . $fromsite);
				DatabaseHandler::close();
				exit();
			}
		}
		else
		{
			header("Location: " . $fromsite);
			DatabaseHandler::close();
			exit();
		}
	}
	else
	{
		header("Location: " . $fromsite);
		DatabaseHandler::close();
		exit();
	}
	//TODO: Kui email ja kasutajanimi ei ole kasutuses, rega konto.
}

DatabaseHandler::close();

header("Location: " . $fromsite);