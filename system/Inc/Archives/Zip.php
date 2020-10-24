<?php

namespace System\Inc\Archives;

use System\Inc\Archives\Interfaces\ArchiveInterface;
use ZipArchive;

class Zip implements ArchiveInterface
{
	
	private $archive;
	
	public function __construct()
	{
		
		$this->archive = new ZipArchive();
		
	}
	
	public function open($patch)
	{
		
		$this->archive->open($patch);
		
		return $this;
		
	}
	
	public function extract($to)
	{

		$this->archive->extractTo($to);
		
	}
	
	public function addFile($where, $nameFolder)
	{
		
		
		
	}
	
	public function addFolder($folder)
	{
		
		
		
	}
	
	public function count()
	{
		
		
		
	}
	
	public function remove($patch)
	{
		
		
		
	}
	
	public function close()
	{
		
		
		
	}
	
}