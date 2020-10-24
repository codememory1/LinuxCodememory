<?php

namespace System\Codememory\Components\Paginator;

use System\Codememory\Components\Paginator\PaginatorInterface;
use System\Codememory\Components\Paginator\Handle as HandlePaginator;
use Jenssegers\Blade\Blade;
use System\Exceptions\SleshPatchException;

class Paginator implements PaginatorInterface
{
	
	public $recordOutput = 10; // Вывод кол-во записей
	
	public $buttonOutput = 5; // Кол-во вывод кнопок
	
	public $data = []; // Массив данных
	
	public function total(array $data)
	{
		
		$this->data = $data;
		
		return $this;
		
	}
	
	public function outputData(int $quantity)
	{
		
		$this->recordOutput = $quantity;
		
		return $this;
		
	}
	
	public function outputButton(int $quantity)
	{
		
		$this->buttonOutput = $quantity;
		
		return $this;
		
	}
	
	public function template($template = 'default')
	{
		
		if(strpos($view, '/') !== false)
			throw new SleshPatchException();
		
		$view = str_replace('.', '/', $view);
		
		$blade = new Blade('../system/Codememory/Components/Paginator/Views/', '../storage/cache/Views');
		
		$data = [
			'paginator' => ['this'   => $this],
			'handle'	=> ['handle' => $this->generate()]
		];
		
		extract($data);
		echo $blade->make($template, $data)->render();
		
		return $this;
		
	}
	
	public function generate():HandlePaginator
	{
		
		return new HandlePaginator($this->recordOutput, $this->buttonOutput, $this->data);
		
	}
	
	
}