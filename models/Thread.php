<?php


class Thread
{
	private $sqlid;
	private $createdBy;
	private $categorie;
	private $name;
	private $content;
	private $rating;
	private $createTime;
	private $posts;

	function __construct($dbRow)
	{
		$this->sqlid = (int) $dbRow['sqlid'];
		$this->createdBy = (int) $dbRow['createdBy'];
		$this->categorie = (int) $dbRow['categorie'];
		$this->name = $dbRow['name'];
		$this->content = $dbRow['content'];
		$this->rating = $dbRow['rating'];
		$this->createTime = $dbRow['createTime'];
	}

	function setPosts($posts)
	{
		$this->posts = $posts;
	}

	function getPosts()
	{
		return $this->posts;
	}

	function getSQLID()
	{
		return $this->sqlid;
	}

	function getCreatedBy()
	{
		return $this->createdBy;
	}

	function getCategorie()
	{
		return $this->categorie;
	}

	function getName()
	{
		return $this->name;
	}

	function getContent()
	{
		return $this->content;
	}

	function getRating()
	{
		return $this->rating;
	}

	function getCreateTime()
	{
		return $this->createTime;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}
}