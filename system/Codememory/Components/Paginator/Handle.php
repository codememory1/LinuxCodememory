<?php

namespace System\Codememory\Components\Paginator;

use Request;

class Handle
{
	
	private $recordOutput;
	
	private $buttonOutput;
	
	private $data = [];
	
	private $totalRecords;
	
	public function __construct($recordOutput, $buttonOutput, $data)
	{

		$this->recordOutput = $recordOutput;
		$this->buttonOutput = $buttonOutput;
		$this->data = $data;
		$this->totalRecords = count($data);
		
	}
	
	public function getOutputButton():int
	{
		
		return ($this->buttonOutput > $this->getNumberPages()) ? $this->getNumberPages() : $this->buttonOutput;
		
	}
	
	public function getButtons()
	{
		
		
		
	}
	
	public function getData():array
	{
		
		$data = array_slice($this->data, $this->getActivePage() - 1, $this->getActivePage() + $this->recordOutput);

		return $data;
		
	}
	
	public function getActivePage():int
	{
		
		$activePage = (Request::get('page')->give()) ?? 1;
		$activePage = $activePage == 0 ? $activePage + 1 : $activePage;
		
		$activePage = ($activePage > $this->getLastPage()) ? $this->getLastPage() : $activePage;
		
		return $activePage;
		
	}
	
	private function getLastPage():int
	{
		
		return $this->getNumberPages();
		
	}
	
	public function getNumberPages()
	{
		
		return ceil($this->totalRecords / $this->recordOutput);
		
	}
	
}