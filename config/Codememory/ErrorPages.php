<?php

return [
	
	404 => [
		'Controller' => 'ErrorControllers\\ErrorController',
		'Method'	 => 'NotFound',
		'File'		 => null
	],
	
	403 => [
		'Controller' => 'ErrorControllers\\ErrorController',
		'Method'	 => 'Forbidden',
		'File'		 => null
	]
	
];
