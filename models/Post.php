<?php


class Post
{
	private $sqlid;
	private $thread;
	private $createdBy;
	private $createTime;
	private $content;
	private $rating;

	function __construct($dbRow)
	{
		$this->sqlid = (int) $dbRow['sqlid'];
		$this->thread = (int) $dbRow['thread'];
		$this->createdBy = (int) $dbRow['createdBy'];
		$this->createTime = $dbRow['createTime'];
		$this->content = $dbRow['content'];
		$this->rating = $dbRow['rating'];
	}

	function getSQLID()
	{
		return $this->sqlid;
	}

	function getThread()
	{
		return $this->thread;
	}

	function getCreatedBy()
	{
		return $this->createdBy;
	}

	function getContent()
	{
		return $this->content;
	}

	function getCreateTime()
	{
		return $this->createTime;
	}

	function getRating()
	{
		return $this->rating;
	}
}