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
	private $categoriesFollowing;

	function __construct($dbRow)
	{
		if($dbRow != null)
		{
			$this->sqlid = (int)$dbRow['sqlid'];
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
			$this->categoriesFollowing = $dbRow['categoriesFollowing'];
		}
		else
		{
			$this->sqlid = -1;
			$this->username = 'Anonymous';
		}
	}

	function getSQLID()
	{
		return $this->sqlid;
	}

	function getUsername()
	{
		return $this->username;
	}

	function getGender()
	{
		return $this->gender;
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

	function getRole()
	{
		return $this->role;
	}

	function getRoleTxt()
	{
		global $translator;
		if($this->role == 0) return $translator->getString('role_regular'); //Regular
		else if($this->role == 1) return $translator->getString('role_trusted'); //Trusted
		else if($this->role == 2) return $translator->getString('role_vip'); //VIP
		else if($this->role == 3) return $translator->getString('role_moderator'); //Moderator
		else if($this->role == 4) return $translator->getString('role_administrator'); //Administrator
		return '';
	}

	function getCategoriesFollowing()
	{
		return $this->categoriesFollowing;
	}

	function getNationality()
	{
		return $this->nationality;
	}

	function getMotto()
	{
		return $this->motto;
	}

	public function getJoindate()
	{
		return $this->joindate;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getHomepage()
	{
		return $this->homepage;
	}

	public function getTimezone()
	{
		return $this->timezone;
	}

	public function setPassword($new_pass)
	{
		$this->password = $new_pass;
	}

	public function setEmail($new_email)
	{
		$this->email = $new_email;
	}

	public function setUsername($new_username)
	{
		$this->username = $new_username;
	}

	public function setAvatar($new_avatar)
	{
		$this->avatar = $new_avatar;
	}

	public function setGender($gender)
	{
		$this->gender = $gender;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function setMotto($motto)
	{
		$this->motto = $motto;
	}

	public function setHomepage($homepage)
	{
		$this->homepage = $homepage;
	}

	public function setNationality($nationality)
	{
		$this->nationality = $nationality;
	}

	public function setTimezone($timezone)
	{
		$this->timezone = $timezone;
	}


}