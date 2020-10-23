<?php

namespace App\Models\Repositories;

/**
 * DocumentationRepository
 */
class DocumentationRepository
{

    const SITEBAR_MENU = [
        'home' => 'Главная',
        'commands' => [
            'title-attachment' => 'Команды',
            'Введение',
            'Инструкция',
            
            'all-commands' => [
                'SHOW - Получение',
                'EMBED - Добавление',
                'UPDATE - Обновление',
                'DELETE - Удаление'
            ],
            'flags-cmd' => [
                'WHERE',
                'LIMIT',
                'SORT'
            ]
        ],
        'migration' => [
            'title-attachment' => 'Миграция',
        ],
        'work-interfaces' => [
            'title-attachment' => 'Работа с интерфейсом Базы Данных',
            
            'components-interfaces' => [
                'title-attachment' => 'Компоненты Интерфейса',

                'Создание Базы Данных',
                'Создание Таблицы',
                'Добавление Данных в Таблицу',
                'Представления',
                'Хранилище Удаленных Данных',
            ],
            'Зарегистрированные колонки'
        ]
    ];
    
    /**
     * getSitebarMenu
     *
     * @return array
     */
    public function getSitebarMenu():array
    {

        return self::SITEBAR_MENU;

    }


}