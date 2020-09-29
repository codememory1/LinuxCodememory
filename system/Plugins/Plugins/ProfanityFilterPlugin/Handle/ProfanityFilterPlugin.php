<?php

namespace CustomPlugin\ProfanityFilterPlugin\Handle;

use Store;

/**
 * Class ProfanityFilterPlugin
 * @package CustomPlugin\ProfanityFilterPlugin\Handle
 */
class ProfanityFilterPlugin
{

    /**
     * @return mixed
     */
	private function getSettings()
	{
		
		return require patch_plugin('ProfanityFilterPlugin', 'settings.php');
		
	}

    /**
     * @return false|string[]
     */
	private function getWords()
	{
		
		$words = file_get_contents(patch_plugin('ProfanityFilterPlugin', $this->getSettings()['path_word_file']));
		
		$arrWords = explode($this->getSettings()['word_separator'], $words);
		
		return $arrWords;
		
	}

	public function execute()
	{
		
		foreach($this->getSettings()['post_request_names'] as $names)
		{
			$_POST[$names] = str_replace($this->getWords(), $this->getSettings()['replace'], $_POST[$names]);
		}
		
	}
	
}