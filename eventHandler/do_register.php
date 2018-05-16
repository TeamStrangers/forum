<?php

require '../config.php';
session_start();
DatabaseHandler::connect();

$values_set = true;
if(!(isset($_POST['username']) && !empty($_POST['username']))) $values_set = false;
if(!(isset($_POST['email']) && !empty($_POST['email']))) $values_set = false;
if(!(isset($_POST['password']) && !empty($_POST['password']))) $values_set = false;

$translator = new Translator($_SESSION['language']);

if($values_set == true)
{
	$username = DatabaseHandler::escape_string($_POST['username']);
	$email = DatabaseHandler::escape_string($_POST['email']);
	$password = hash('sha256', $salt . DatabaseHandler::escape_string($_POST['password']));

	//TODO: Kui email ja kasutajanimi ei ole kasutuses, rega konto.
}

DatabaseHandler::close();

header("Location: index.php?msg[0]=error&msg[1]=" . $translator->getString('unexpectederror'));