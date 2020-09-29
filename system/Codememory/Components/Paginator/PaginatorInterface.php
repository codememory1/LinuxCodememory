<?php

namespace System\Codememory\Components\Paginator;

interface PaginatorInterface
{
	
	public function total(array $data);
	
	public function outputData(int $quantity);
	
	public function outputButton(int $quantity);
	
}