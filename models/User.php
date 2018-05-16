<?php


class User
{
	private $sqlid;
	private $username;
	private $password;
	private $email;
	private $joindate;
	private $sitelanguage;
	private $gender;
	private $avatar;
	private $role;
	private $description;
	private $motto;
	private $homepage;
	private $nationality;
	private $timezone;

	function __construct($dbRow)
	{
		$this->sqlid = (int) $dbRow['sqlid'];
		$this->username = $dbRow['username'];
		$this->password = $dbRow['password'];
		$this->email = $dbRow['email'];
		$this->joindate = $dbRow['joindate'];
		$this->sitelanguage = $dbRow['sitelanguage'];
		$this->gender = $dbRow['gender'];
		$this->avatar = $dbRow['avatar'];
		$this->role = $dbRow['role'];
		$this->description = $dbRow['description'];
		$this->motto = $dbRow['motto'];
		$this->homepage = $dbRow['homepage'];
		$this->nationality = $dbRow['nationality'];
		$this->timezone = $dbRow['timezone'];
	}

	function getSQLID()
	{
		return $this->sqlid;
	}

	function getUsername()
	{
		return $this->username;
	}

	function getEmail()
	{
		return $this->email;
	}

	function getPassword()
	{
		return $this->password;
	}

	function getSiteLanguage()
	{
		return $this->sitelanguage;
	}

	function getAvatar()
	{
		return $this->avatar;
	}
}