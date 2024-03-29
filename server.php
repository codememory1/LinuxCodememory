<?php

    use System\Codememory\CodememoryContainer;
    use System\Classes\AliasesContainer;
    use System\Classes\Facade\Facade;
    use System\Codememory\CodememoryConfigurationLanguage\ReinforcerCodememory;
    
		session_start();

    // /*
    // * ===_===_===_===_===_===_===_===_===_===_===_===_===_===_==
    // * ==========================================================
    // * Подключение файла "autoload" для авто подключение классов
    // * ==========================================================
    // * ===_===_===_===_===_===_===_===_===_===_===_===_===_===_==
    // */
    // require __DIR__ .'/vendor/autoload.php';

    /*
    * ===_===_===_===_===_===_===_===_===_===_===_===_===_===_==
    * ==========================================================
    * Подключение файла Функций
    * ==========================================================
    * ===_===_===_===_===_===_===_===_===_===_===_===_===_===_==
    */

    require __DIR__ . "/system/libs/Plugins/CommonFunctionsPlugins.php";

    /*
    * ===_===_===_===_===_===_===_===_===_===_=
    * =========================================
    * Создаем путь к файлу ".env" Dotenv\Dotenv
    * =========================================
    * ===_===_===_===_===_===_===_===_===_===_=
    */
    
    $dotenv = Dotenv\Dotenv::create(__DIR__, '.env');
    $dotenv->load();

    /*
    * ===_===_===_===_===_===_===_===_===_===_=
    * =========================================
    * Конструкция try catch создаем экзымпляр
    * Основного нашего класса "Codememory"
    * Передаем туда параметр класса "DI"
    * Создаем цикл foreach и подключаем все 
    * Провайдеры, подключаем файл app.php
    * Это настройки из .env в массиве
    * =========================================
    * ===_===_===_===_===_===_===_===_===_===_=
    */

    try {
		
        new Facade();
        new AliasesContainer();

        Facade::installStaticMethod();
        AliasesContainer::getList();
        
        ReinforcerCodememory::compline();
        \Url::defaultPath();
		
        $container = new CodememoryContainer();
        $container->runFramework();
		

    } catch (ErrorException $ex) {
        
		echo $ex->getMessage();
         
    }

