<?php

class DatabaseHandler
{
	public static $connection;

	static function connect()
	{
		require SITE_LOCATION . '/config.php';
		self::$connection = new mysqli($mysql['hostname'], $mysql['username'], $mysql['password'], $mysql['database']);
		if(self::$connection->connect_error)
		{
			//die(self::$connection->connect_error);
			die("Unexpected error occured.");
		}

		if(isset($_SESSION['sqlid']))
		{
			global $current_user;
			$sqlid = (int) $_SESSION['sqlid'];
			$current_user = self::getUserBySQLID($sqlid);
		}
	}

	static function escape_string($string)
	{
		return self::$connection->escape_string($string);
	}

	static function close()
	{
		self::$connection->close();
	}

	static function getAllUsers()
	{
		require SITE_LOCATION . '/config.php';
		$user_list = array();
		$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'users`');
		while($row = $query->fetch_assoc())
		{
			$user = new User($row);
			array_push($user_list, $user);
		}
		return $user_list;
	}

	static function getUserBySQLID($sqlid)
	{
		require SITE_LOCATION . '/config.php';
		$sqlid = self::escape_string($sqlid);
		$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'users` WHERE `sqlid` = \'' . $sqlid . '\' LIMIT 1');
		if($query->num_rows > 0)
		{
			$user = new User($query->fetch_assoc());
			return $user;
		}
		else return null;
	}

	static function updateLanguage($user, $language)
	{
		$sqlid = (int) $user->getSQLID();
		self::$connection->query('UPDATE `' . $mysql['dbprefix'] . 'users` SET `sitelanguage` = \'' . $language . '\' WHERE `sqlid` = \'' . $sqlid . '\'');
	}

	static function createUser($username, $email, $password)
	{
		require SITE_LOCATION . '/config.php';
		$username = DatabaseHandler::escape_string($username);
		$email = DatabaseHandler::escape_string($email);
		$password = DatabaseHandler::escape_string($password);
		$query = self::$connection->query('INSERT INTO `' . $mysql['dbprefix'] . 'users` (username, password, email, joindate, sitelanguage) VALUES (\'' . $username . '\', \'' . $password . '\', \'' . $email . '\', \'' . time() . '\', \'' . $_SESSION['language'] . '\')');
		return $query->last_insert_id;
	}
}