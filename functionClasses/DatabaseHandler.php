<?php

class DatabaseHandler
{
	private static $user_list = array();


	static $connection;

	static function connect()
	{
		require 'config.php';
		self::$connection = new mysqli($mysql['hostname'], $mysql['username'], $mysql['password'], $mysql['database']);
		if(self::$connection->connect_error)
		{
			die(self::$connection->connect_error);
		}

		$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'users`');
		while($row = $query->fetch_assoc())
		{
			$user = new User($row);
			array_push($user_list, $user);
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
		return self::$user_list;
	}

	static function getUserBySQLID($sqlid)
	{
		foreach(self::$user_list as $item)
		{
			if(is_a($item, "User"))
			{
				if($item->getSQLID() == $sqlid)
				{
					return $item;
				}
			}
		}
		return null;
	}
}