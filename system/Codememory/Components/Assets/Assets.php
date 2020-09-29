<?php

namespace System\Codememory\Components\Assets;

use System\Codememory\Components\Assets\AssetsInterface;
use System\Codememory\Components\Assets\AssetsHandle;

class Assets implements AssetsInterface
{
	
	public function execute()
	{
		
		return new AssetsHandle('/src/Assets/');
		
	}
	

}



