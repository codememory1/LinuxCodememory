<?php

namespace System\Codememory\Components\UploadFiles;

use System\Codememory\Components\UploadFiles\Handle as HandleUpload;

/**
 * Class Upload
 * @package System\Codememory\Components\UploadFiles
 */
class Upload
{

    /**
     * @var string|int
     */
	private $maxSize = '*'; // * - любой размер

    /**
     * @var string|int
     */
	private $minSize = '*'; // * - любой размер

    /**
     * @var array
     */
	private $listUnit = [
		
		'KB' => (999 * 1000),
		'MB' => (999 * 1024 * 1024),
		'B'	 => 999,
		'GB' => (999 * 1024 * 1024 * 1024)
		
	]; // 999 - замена числа на пользовательское

    /**
     * @var string
     */
	private $unitSelected = 'KB'; // По умолчанию Единица измерения в KB

    /**
     * @var array
     */
	private $type = [];

    /**
     * @var array
     */
	private $mimeType = [];

    /**
     * @var string
     */
	private $uploadTo;

    /**
     * @var array
     */
	private $names = [];

    /**
     * @var int
     */
	private $minFile = 1;

    /**
     * @var int
     */
	private $maxFile = 1;
	
	 /**
     * @var string
     */
	private $nameInputUploaded;

    /**
     * Максимальный размер файла
     *
     * @param   int $max
     *
     * @return $this
     */
	public function maxSize(int $max)
	{
		
		$this->maxSize = $max;
		
		return $this;
		
	}

    /**
     * Минимальный размер файла
     *
     * @param   int $min
     *
     * @return $this
     */
	public function minSize(int $min)
	{
		
		$this->minSize = $min;
		
		return $this;
		
	}

    /**
     * Единица измерения
     *
     * @param   string $unit
     *
     * @return $this
     */
	public function unit(string $unit)
	{
		
		$this->unitSelected = up_line($unit);
		
		return $this;
		
	}

    /**
     * Тип файла(расширение файла) - png
     *
     * @param   array $type
     *
     * @return $this
     */
	public function type(array $type)
	{
		
		$this->type = array_combine($type, $type);
		
		return $this;
		
	}

    /**
     * MimeType двухчастный идентификатор(image/png)
     *
     * @param   array $mime
     *
     * @return $this
     */
	public function mimeType(array $mime)
	{
		
		$this->mimeType = array_combine($mime, $mime);
		
		return $this;
		
	}

    /**
     * Минимальное кол-во загруженый файлов
     *
     * @param   int $min
     *
     * @return $this
     */
	public function minFile(int $min)
	{
		
		$this->minFile = $min;
		
		return $this;
		
	}

    /**
     * Максимальное кол-во загруженый файлов
     *
     * @param   int $max
     *
     * @return $this
     */
	public function maxFile(int $max)
	{
		
		$this->maxFile = $max;
		
		return $this;
		
	}
	
	/**
     * Массив имен для загружаемых файлов
     *
     * @param   array $names
     *
     * @return $this
     */
	public function names(array $names)
	{
		
		$this->names = $names;
		
		return $this;
		
	}
	
	/**
     * Путь, куда загрузить файлы
     *
     * @param   string $uploadTo
     *
     * @return $this
     */
	public function uploadTo(string $uploadTo)
	{
		
		$this->uploadTo = $uploadTo;
		
		return $this;
		
	}
	
	/**
     * Имя инпута с которого загружаются файлы
     *
     * @param   string $uploadTo
     *
     * @return $this
     */
	public function input(string $name)
	{
		
		$this->nameInputUploaded = $name;
		
		return $this;
		
	}

    /**
     * Основной метод загрузки
     *
     * @param $nameUpload
     * @param   callable|null $callback
     *
     * @return Handle
     */
	public function load(callable $callback = null)
	{
		
		$uploadHandle = new HandleUpload(
			$this->maxSize, 
			$this->minSize, 
			$this->listUnit, 
			$this->unitSelected, 
			$this->type, 
			$this->mimeType, 
			$this->nameInputUploaded, 
			$this->uploadTo, 
			$this->names, 
			$this->minFile, 
			$this->maxFile
		);
		$load = $uploadHandle->upload();
		
		return ($load === true) ? call_user_func_array($callback, [$uploadHandle]) : false;
		
	}
	
	
}