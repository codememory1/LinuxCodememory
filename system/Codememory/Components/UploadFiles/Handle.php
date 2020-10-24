<?php

namespace System\Codememory\Components\UploadFiles;

use Request;
use Store;

/**
 * Class Handle
 * @package System\Codememory\Components\UploadFiles
 */
class Handle
{

    /**
     * @var int
     */
	private $maxSize;

    /**
     * @var int
     */
	private $minSize;

    /**
     * @var array
     */
	private $listUnit = [];

    /**
     * @var string
     */
	private $unitSelected;

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
	private $nameUpload;

    /**
     * @var string[]
     */
	private $errorList = [
		
		'ERR_TYPE_FILE' 	 	 => 'Некорректный тип файла',
		'ERR_MIME_TYPE_FILE' 	 => 'Некорректный mime тип файла',
		'ERR_MIN_SIZE_FILE'  	 => 'Размер загруженого файла слишком мал',
		'ERR_MAX_SIZE_FILE'  	 => 'Размер загруженого файла слишком велик',
		'ERR_QUANTITY_MIN_FILE'  => 'Кол-во загржаемых файлов превышает выше минимума',
		'ERR_QUANTITY_MAX_FILE'  => 'Кол-во загржаемых файлов превышает выше максимума',
		
	];

    /**
     * @var array
     */
	private $activeErrors = [];

    /**
     * @var
     */
	private $files = [];

    /**
     * @var
     */
	private $uploadTo;

    /**
     * @var array
     */
	private $names = [];

    /**
     * @var int
     */
	private $minFile;

    /**
     * @var
     */
	private $maxFile;

    /**
     * Handle constructor.
     *
     * @param $maxSize
     * @param $minSize
     * @param $listUnit
     * @param $unitSelected
     * @param $type
     * @param $mimeType
     * @param $nameUpload
     * @param $uploadTo
     * @param $names
     * @param $minFile
     * @param $maxFile
     */
	public function __construct($maxSize, $minSize, $listUnit, $unitSelected, $type, $mimeType, $nameUpload, $uploadTo, $names, $minFile, $maxFile)
	{
		
		$this->maxSize = $maxSize;
		$this->minSize = $minSize;
		$this->listUnit = $listUnit;
		$this->unitSelected = $unitSelected;
		$this->type = $type;
		$this->mimeType = $mimeType;
		$this->nameUpload = $nameUpload;
		$this->files = (object) Request::files($this->nameUpload);
		$this->uploadTo = rtrim($uploadTo, '/').'/';
		$this->names = $names;
		$this->minFile = $minFile;
        $this->maxFile = $maxFile;
		
	}

    /**
     * Получить размер в байтах
     *
     * @param $weight
     * @param   string $unit
     *
     * @return int
     */
	private function weight($weight, string $unit):int
	{
		
		return Store::replace([999 => $weight], $this->listUnit[up_line($unit)]);
		
	}

    /**
     * Основной метод проверки всех типов файла mimeType и Type
     *
     * @param   array $typeUpload
     * @param   array $validTypes
     *
     * @return bool
     */
	private function handleTypesChecking(array $typeUpload, array $validTypes):bool
	{
		
		$statusTypes = true;
		
		foreach($typeUpload as $keyNum => $type)
		{
			if(!array_key_exists($type, $validTypes))
				$statusTypes = false;
				
		}
		
		return $statusTypes;
		
	}

    /**
     * Проверка на MimeType
     *
     * @param   array $mimeType
     *
     * @return bool
     */
	private function checkMimeType(array $mimeType)
	{
		
		return $this->handleTypesChecking($mimeType, $this->mimeType);
		
	}

    /**
     * Проверка на допустимые типы(png,jpg...)
     *
     * @param   array $types
     *
     * @return bool
     */
	private function checkValidTypes(array $types)
	{

		return $this->handleTypesChecking($types, $this->type);
		
	}

    /**
     * Метод провки всех типов файла
     *
     * @param   array $mimeType
     * @param   array $types
     *
     * @return bool
     */
	private function performTypeChecking(array $mimeType, array $types):bool
	{
		
		$statysTypes = [
			'mimeType' => true,
			'type'	   => true
		];
		
		if(count($this->mimeType) > 0)
			$statysTypes['mimeType'] = $this->checkMimeType($mimeType);
		
		if(count($this->type) > 0)
			$statysTypes['type'] = $this->checkValidTypes($types);
		
		($statysTypes['mimeType'] === false) ? $this->activeErrors += $this->getError('ERR_MIME_TYPE_FILE') : null;
		($statysTypes['type'] === false) ? $this->activeErrors += $this->getError('ERR_TYPE_FILE') : null;
		
		return ($statysTypes['mimeType'] !== $statysTypes['type']) ? false : true;

	}

    /**
     * Метод проверки размера файла на максимальный
     *
     * @param   array $sizes
     *
     * @return bool
     */
	private function maxSizeCheck(array $sizes):bool
	{
		
		$statusSize = true;
		
		foreach($sizes as $keyNum => $size)
		{
			if($size > $this->weight($this->minSize, $this->unitSelected))
				$statusSize = false;
		}
		
		($statusSize === false) ? $this->activeErrors += $this->getError('ERR_MAX_SIZE_FILE') : null;
		
		return $statusSize;
		
	}

    /**
     * Метод проверки размера файла на минимуальный
     *
     * @param   array $sizes
     *
     * @return bool
     */
	private function minSizeCheck(array $sizes):bool
	{
		
		$statusSize = true;
		
		foreach($sizes as $keyNum => $size)
		{
			if($size < $this->weight($this->minSize, $this->unitSelected))
				$statusSize = false;
		}
		
		($statusSize === false) ? $this->activeErrors += $this->getError('ERR_MIN_SIZE_FILE') : null;
		
		return $statusSize;
		
	}

    /**
     * Проверка на кол-во загруженый файлов МИНИМУМ
     *
     * @param   array $tmp
     *
     * @return bool
     */
	private function quantityFilesMin(array $tmp)
	{
		
		$statusQuantity = (count($tmp) < $this->minFile) ? false : true;
		
		($statusQuantity === false) ? $this->activeErrors += $this->getError('ERR_QUANTITY_MIN_FILE') : null;
		
		return $statusQuantity;
		
	}

    /**
     * Проверка на кол-во загруженый файлов МАКСИМУМ
     *
     * @param   array $tmp
     *
     * @return bool
     */
	private function quantityFilesMax(array $tmp)
	{
		
		$statusQuantity = (count($tmp) > $this->maxFile) ? false : true;
		
		($statusQuantity === false) ? $this->activeErrors += $this->getError('ERR_QUANTITY_MAX_FILE') : null;
		
		return $statusQuantity;
		
	}

    /**
     * Возврощает массив ошибки по ключу
     *
     * @param $errorKey
     *
     * @return array|string[]
     */
	private function getError($errorKey):array
	{
		
		return [$errorKey => $this->errorList[$errorKey]];
		
	}

    /**
     * Возврощает массив всех ошибок
     *
     * @param   string|null $code
     *
     * @return array|string[]
     */
	public function getAllErrors(string $code = null):array
	{
		
		return (!is_null($code)) ? $this->getError($code) : $this->errorList;
		
	}

    /**
     * Возврощает массив всех активный ошибок
     *
     * @param   string|null $code
     *
     * @return array|string[]
     */
	public function getActiveErrors(string $code = null):array
	{
		
		return (!is_null($code)) ? $this->getError($code) : $this->activeErrors;
		
	}

    /**
     * Возврощает массив захэшированых имен файлов
     *
     * @return array
     */
	public function getNames():array
	{
		
		$names = [];
		
		foreach($this->files->hash_name as $k => $name)
			$names[] = [
				'file' 		=> $name.'.'.$this->files->type[$k],
				'path_file' => $this->uploadTo.$name.'.'.$this->files->type[$k]
			];
		
		if(count($this->names) > 0)
		{
			$names = [];
			foreach($this->names as $k => $name)
				$names[] = [
					'file' 		=> $name.'.'.$this->files->type[$k],
					'path_file' => $this->uploadTo.$name.'.'.$this->files->type[$k]
				];
		}
			

		return $names;
		
	}

    /**
     * Загружает файлы
     *
     * @param   array $tmp
     *
     * @return bool
     */
	private function handleUploadFile(array $tmp)
	{
		
		foreach($tmp as $k => $tmpName)
		{
			Store::upload($tmpName, $this->uploadTo.$this->getNames()[$k]['file']);
		}
		
		return true;
		
	}

    /**
     * Основной метод в котором вызываются все методы проверки
     */
	public function upload()
	{
		
		$types = $this->performTypeChecking($this->files->mime_type, $this->files->type);
		
		$minSize = ($this->minSize != '*') ? $this->minSizeCheck($this->files->size) : true;
		
		$maxSize = ($this->maxSize != '*') ? $this->maxSizeCheck($this->files->size) : true;
		
		$quantityFilesMin = $this->quantityFilesMin($this->files->tmp_name);
		$quantityFilesMax = $this->quantityFilesMax($this->files->tmp_name);
		
		if($types === true && $minSize === true && $maxSize === true && $quantityFilesMin === true && $quantityFilesMax === true)
			return $this->handleUploadFile($this->files->tmp_name);
		
	}
	
}