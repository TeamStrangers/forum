<?php

class DatabaseHandler
{
	public static $connection;

	private static $categories = null;
	private static $threads = null;
	private static $posts = null;

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

	static function createThread($category, $createdBy, $name, $content)
	{
		require SITE_LOCATION . '/config.php';

		$category = DatabaseHandler::escape_string($category);
		$createdBy = DatabaseHandler::escape_string($createdBy);
		$name = DatabaseHandler::escape_string($name);
		$content = DatabaseHandler::escape_string($content);

		$query = self::$connection->query('INSERT INTO `' . $mysql['dbprefix'] . 'threads` (createdBy, categorie, name, content, createTime) VALUES (\'' . $createdBy . '\', \'' . $category . '\', \'' . $name . '\', \'' . $content . '\', \'' . time() . '\')');
		return $query->last_insert_id;
	}

	static function createPost($thread, $createdBy, $content)
	{
		require SITE_LOCATION . '/config.php';

		$thread = DatabaseHandler::escape_string($thread);
		$createdBy = DatabaseHandler::escape_string($createdBy);
		$content = DatabaseHandler::escape_string($content);

		$query = self::$connection->query('INSERT INTO `' . $mysql['dbprefix'] . 'posts` (createdBy, thread, content, createTime) VALUES (\'' . $createdBy . '\', \'' . $thread . '\', \'' . $content . '\', \'' . time() . '\')');
		return $query->last_insert_id;
	}

	static function getCategoriesByList($categories, $withThreads = false, $withPosts = false)
	{
		require SITE_LOCATION . '/config.php';
		$list = array();
		$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'categories` WHERE `sqlid` IN(' . $categories . ')');
		while($row = $query->fetch_assoc())
		{
			$categorie = new Categorie($row);
			if($withThreads)
			{
				$query2 = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'threads` WHERE `categorie` = \'' . $categorie->getSQLID() . '\'');
				$threads = array();
				while($row2 = $query2->fetch_assoc())
				{
					$thread = new Thread($row2);
					if($withPosts)
					{
						$posts = array();
						$query3 = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'posts` WHERE `thread` = \'' . $thread->getSQLID() . '\'');
						while($row3 = $query3->fetch_assoc())
						{
							$post = new Post($row3);
							array_push($posts, $post);
						}
						$thread->setPosts($posts);
					}
					array_push($threads, $thread);
				}
				$categorie->setThreads($threads);
			}
			array_push($list, $categorie);
		}
		return $list;
	}

	static function getCategories()
	{
		require SITE_LOCATION . '/config.php';
		if(self::$categories == null)
		{
			$list = array();
			$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'categories`');
			while($row = $query->fetch_assoc())
			{
				$categorie = new Categorie($row);
				array_push($list, $categorie);
			}
			self::$categories = $list;
			return $list;
		}
		else return self::$categories;
	}

	static function getThreadCategory($thread)
	{
		foreach(DatabaseHandler::getCategories() as $category)
		{
			if($thread->getCategorie() == $category->getSQLID())
			{
				return $category;
			}
		}
		return null;
	}

	static function getThreadsByUser($user)
	{
		$list = array();
		foreach(DatabaseHandler::getThreads() as $thread)
		{
			if($thread->getCreatedBy() == $user->getSQLID())
			{
				array_push($list, $thread);
			}
		}
		return $list;
	}

	static function getPostsByUser($user)
	{
		$list = array();
		foreach(DatabaseHandler::getPosts() as $post)
		{
			if($post->getCreatedBy() == $user->getSQLID())
			{
				array_push($list, $post);
			}
		}
		return $list;
	}

	static function getThreads()
	{
		require SITE_LOCATION . '/config.php';
		if(self::$threads == null)
		{
			$list = array();
			$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'threads`');
			while($row = $query->fetch_assoc())
			{
				$thread = new Thread($row);
				array_push($list, $thread);
			}
			self::$threads = $list;
			return $list;
		}
		else return self::$threads;
	}

	static function getThreadsByTime()
	{
		require SITE_LOCATION . '/config.php';
		$list = array();
		$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'threads` ORDER BY createTime DESC');
		while($row = $query->fetch_assoc())
		{
			$thread = new Thread($row);
			array_push($list, $thread);
		}
		self::$threads = $list;
		return $list;
	}

	static function getThreadsByCategory($category, $withPosts = false)
	{
		require SITE_LOCATION . '/config.php';
		$list = array();
		$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'threads` WHERE `categorie` = \'' . $category . '\'');
		while($row = $query->fetch_assoc())
		{
			$thread = new Thread($row);
			if($withPosts)
			{
				$posts = array();
				$query3 = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'posts` WHERE `thread` = \'' . $thread->getSQLID() . '\'');
				while($row3 = $query3->fetch_assoc())
				{
					$post = new Post($row3);
					array_push($posts, $post);
				}
				$thread->setPosts($posts);
			}
			array_push($list, $thread);
		}
		return $list;
	}

	static function getPosts()
	{
		require SITE_LOCATION . '/config.php';
		if(self::$posts == null)
		{
			$list = array();
			$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'posts`');
			while($row = $query->fetch_assoc())
			{
				$thread = new Post($row);
				array_push($list, $thread);
			}
			self::$posts = $list;
			return $list;
		}
		else return self::$posts;
	}

	static function getThreadBySQLID($sqlid, $withPosts = false)
	{
		require SITE_LOCATION . '/config.php';
		$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'threads` WHERE `sqlid` = \'' . $sqlid . '\' LIMIT 1');
		if($query->num_rows > 0)
		{
			$thread = new Thread($query->fetch_assoc());
			if($withPosts)
			{
				$query2 = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'posts` WHERE `thread` = \'' . $thread->getSQLID() . '\'');
				$posts = array();
				while($row = $query2->fetch_assoc())
				{
					$post = new Post($row);
					array_push($posts, $post);
				}
				$thread->setPosts($posts);
			}
			return $thread;
		}
		else return null;
	}

	static function getPostBySQLID($sqlid)
	{
		require SITE_LOCATION . '/config.php';
		$query = self::$connection->query('SELECT * FROM `' . $mysql['dbprefix'] . 'posts` WHERE `sqlid` = \'' . $sqlid . '\' LIMIT 1');
		if($query->num_rows > 0)
		{
			$post = new Post($query->fetch_assoc());
			return $post;
		}
		else return null;
	}

	static function saveUser($user)
	{
		require SITE_LOCATION . '/config.php';

		$fields = '`username` = \'' . $user->getUsername() . '\',';
		$fields .= '`password` = \'' . $user->getPassword() . '\',';
		$fields .= '`email` = \'' . $user->getEmail() . '\',';
		$fields .= '`sitelanguage` = \'' . $user->getSiteLanguage() . '\',';
		$fields .= '`gender` = \'' . $user->getGender() . '\',';
		$fields .= '`avatar` = \'' . $user->getAvatar() . '\',';
		$fields .= '`role` = \'' . $user->getRole() . '\',';
		$fields .= '`description` = \'' . $user->getDescription() . '\',';
		$fields .= '`motto` = \'' . $user->getMotto() . '\',';
		$fields .= '`homepage` = \'' . $user->getHomepage() . '\',';
		$fields .= '`nationality` = \'' . $user->getNationality() . '\',';
		$fields .= '`timezone` = \'' . $user->getTimezone() . '\',';
		$fields .= '`categoriesFollowing` = \'' . $user->getCategoriesFollowing() . '\'';

		self::$connection->query('UPDATE `' . $mysql['dbprefix'] . 'users` SET ' . $fields . ' WHERE `sqlid` = \'' . $user->getSQLID() . '\'');
	}

	static function saveThread($thread)
	{
		require SITE_LOCATION . '/config.php';

		$fields = '`createdBy` = \'' . $thread->getCreatedBy() . '\',';
		$fields .= '`categorie` = \'' . $thread->getCategorie() . '\',';
		$fields .= '`name` = \'' . $thread->getName() . '\',';
		$fields .= '`content` = \'' . $thread->getContent() . '\'';

		self::$connection->query('UPDATE `' . $mysql['dbprefix'] . 'threads` SET ' . $fields . ' WHERE `sqlid` = \'' . $thread->getSQLID() . '\'');
	}

	static function deleteThread($thread)
	{
		require SITE_LOCATION . '/config.php';

		self::$connection->query('DELETE FROM `' . $mysql['dbprefix'] . 'threads` WHERE `sqlid` = \'' . $thread->getSQLID() . '\'');
	}

	static function deletePost($post)
	{
		require SITE_LOCATION . '/config.php';

		self::$connection->query('DELETE FROM `' . $mysql['dbprefix'] . 'posts` WHERE `sqlid` = \'' . $post->getSQLID() . '\'');
	}
}