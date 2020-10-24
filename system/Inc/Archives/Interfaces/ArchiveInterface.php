<?php

namespace System\Inc\Archives\Interfaces;

interface ArchiveInterface
{
	
	/* Открывает архив */
	public function open($patch);
	
	/* Извлекает содержимое архива в $to */
	public function extract($to);
	
	/* Создает новый файл в архиве  */
	public function addFile($where, $nameFolder);
	
	/* Создает новую папку в архиве */
	public function addFolder($folder);
	
	/* Подчитывае кол-во файлов в архиве */
	public function count();
	
	/* Удаляет элемент в архиве*/
	public function remove($patch);
	
	/* Закрывает открытый архив */
	public function close();
	
}