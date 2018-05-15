<?php

class Translator
{
	private $language = 'en';

	function __construct($lng)
	{
		$this->language = $lng;
	}

	function getLanguageCode()
	{
		return $this->language;
	}

	function getLanguageName()
	{
		if($this->language == 'en') return 'English';
		else if($this->language == 'et') return 'Estonian';
	}

	function getString($strName, $variableContents = null)
	{
		require 'english.php';
		require 'estonian.php';
		if(is_null($variableContents))
		{
			return $language[$this->language][$strName];
		}
		else if(is_array($variableContents))
		{
			$string = $language[$this->language][$strName];
			foreach($variableContents as $key => $value)
			{
				$string = str_ireplace('{'.$key.'}', $value, $string);
			}
			return $string;
		}
	}
}