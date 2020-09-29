<?php

namespace System\Codememory\AbstractComponent;

use System\Codememory\AbstractComponent\View;

class ViewFactory
{
	
	public function __construct()
	{
		
		$n = new View();
		
		debug($n->getVars());
		
	}
	
}