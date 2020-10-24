<?php

namespace System\Codememory\Components\Assets;

use System\Codememory\Components\Assets\AssetsInterface;

class Build implements AssetsInterface
{
	
	public function execute()
	{
		
		return new AssetsHandle('/src/Build/');
		
	}


}



