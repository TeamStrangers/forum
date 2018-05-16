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

	function getString($strName, $variableContents = null)
	{
		require SITE_LOCATION . '/translations/english.php';
		require SITE_LOCATION . '/translations/estonian.php';
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

	static function getLanguageName($code)
	{
		require SITE_LOCATION . '/translations/english.php';
		require SITE_LOCATION . '/translations/estonian.php';
		return $language[$code]['languagename'];
	}
}