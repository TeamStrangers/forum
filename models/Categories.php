<?php


class Categories
{
	private $sqlid;
	private $parent;
	private $name;
	private $threads;

	function __construct($dbRow)
	{
		$this->sqlid = (int) $dbRow['sqlid'];
		$this->parent = $dbRow['parent'];
		$this->name = $dbRow['name'];
	}

	function setThreads($threads)
	{
		$this->threads = $threads;
	}

	function getThreads()
	{
		return $this->threads;
	}

	function getSQLID()
	{
		return $this->sqlid;
	}

	function getParent()
	{
		return $this->parent;
	}

	function getName()
	{
		return $this->name;
	}

	function __toString()
	{
		return (string)$this->getName();
	}
}