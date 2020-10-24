<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>FastDB - Документация</title>
	
	<?php echo \Assets::execute()->css('all.min'); ?>
	<?php echo \Build::execute()->css('main.min'); ?>
</head>
<body class="doc">

<div class="doc-container">
    <header class="doc-header grid">
        <div class="doc-logo" style="padding: 0;">
            <!-- <h1>FastDB</h1>
            <span>База Данных - для хранения информации</span> -->
            <img src="/src/images/logo.svg" style="width: 258px;">
        </div>
        <div class="doc-git-right">
            <a href="" class="doc-icon-github"><i class="fab fa-github"></i> GitHub</a>
        </div>
    </header>
    <div class="doc-menu-header">
        <ul class="doc-menu-ul">
            <a href="">
                <li>Главная</li>
            </a>
            <a href="">
                <li>Новости</li>
            </a>
            <a href="">
                <li>Поддержка</li>
            </a>
            <a href="">
                <li>Документация</li>
            </a>
        </ul>
    </div>
    <div class="doc-content">
        <div class="doc-sitebar">
            <ul>
                <a href="">
                    <li class="link">
                        <span>
                            Главная
                        </span>
                    </li>
                </a>
                <li class="link-click" id="commands">
                    <span>Команды</span>
                    <ul>
                        <a href="<?php echo route('FastDB.docs'); ?>?link=commands_introduction" title="Введение">
                            <li class="link" id="introduction">
                                <span>Введение</span>
                            </li>
                        </a>
                        <a href="<?php echo route('FastDB.docs'); ?>?link=commands_instruction" title="Инструкция">
                            <li class="link" id="instruction">
                                <span>Инструкция</span>
                            </li>
                        </a>
                        <li class="link-click" id="available-Commands">
                            <span>Доступные Команды</span>
                            <ul>
                                <a href="<?php echo route('FastDB.docs'); ?>?link=commands_available-Commands_cmd-show" title="SHOW">
                                    <li class="link" id="cmd-show">
                                        <span>SHOW - Получение</span>
                                    </li>
                                </a>
                                <a href="<?php echo route('FastDB.docs'); ?>?link=commands_available-Commands_cmd-embed" title="EMBED">
                                    <li class="link" id="cmd-embed">
                                        <span>EMBED - Добавление</span>
                                    </li>
                                </a>
                                <a href="<?php echo route('FastDB.docs'); ?>?link=commands_available-Commands_cmd-update" title="UPDATE">
                                    <li class="link" id="cmd-update">
                                        <span>UPDATE - Обновление</span>
                                    </li>
                                </a>
                                <a href="<?php echo route('FastDB.docs'); ?>?link=commands_available-Commands_cmd-delete" title="DELETE">
                                    <li class="link" id="cmd-delete">
                                        <span>DELETE - Удаление</span>
                                    </li>
                                </a>
                                <li class="link-click" id="flags-for-Teams">
                                    <span>Флаги для Команд</span>
                                    <ul>
                                        <a href="<?php echo route('FastDB.docs'); ?>?link=commands_available-Commands_flags-for-Teams_flag-instruction" title="Инструкция по работе с Флагами">
                                            <li class="link" id="flag-instruction">
                                                <span>Инструкция</span>
                                            </li>
                                        </a>
                                        <a href="<?php echo route('FastDB.docs'); ?>?link=commands_available-Commands_flags-for-Teams_flag-where" title="WHERE">
                                            <li class="link" id="flag-where">
                                                <span>WHERE</span>
                                            </li>
                                        </a>
                                        <a href="<?php echo route('FastDB.docs'); ?>?link=commands_available-Commands_flags-for-Teams_flag-limit" title="LIMIT">
                                            <li class="link" id="flag-limit">
                                                <span>LIMIT</span>
                                            </li>
                                        </a>
                                        <a href="<?php echo route('FastDB.docs'); ?>?link=commands_available-Commands_flags-for-Teams_flag-sort-by-numbers" title="SORT-BY-NUMBERS">
                                            <li class="link" id="flag-sort-by-numbers">
                                                <span>SORT-BY-NUMBERS</span>
                                            </li>
                                        </a>
                                        <a href="<?php echo route('FastDB.docs'); ?>?link=commands_available-Commands_flags-for-Teams_flag-if" title="IF">
                                            <li class="link" id="flag-if">
                                                <span>IF</span>
                                            </li>
                                        </a>
                                        <a href="<?php echo route('FastDB.docs'); ?>?link=commands_available-Commands_flags-for-Teams_flag-notIf" title="NOT-IF">
                                            <li class="link" id="flag-notIf">
                                                <span>NOT-IF</span>
                                            </li>
                                        </a>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="link-click" id="migration">
                    <span>Миграция</span>
                </li>
                <li class="link-click" id="work-Interface-db">
                    <span>Работа с интерфейсом Базы Данных</span>
                    <ul>
                        <li class="link-click" id="components-interfaces">
                            <span>Компоненты Интерфейса</span>
                            <ul>
                                <a href="">
                                    <li class="link">
                                        <span>Создание Базы Данных</span>
                                    </li>
                                </a>
                                <a href="">
                                    <li class="link">
                                        <span>Создание Таблицы</span>
                                    </li>
                                </a>
                                <li class="link-click" id="add-data-in-Table">
                                    <span>Добавление Данных в Таблицу</span>
                                    <ul>
                                        <a href="">
                                            <li class="link">
                                                <span>Жизнь Записи</span>
                                            </li>
                                        </a>
                                    </ul>
                                </li>
                                <a href="">
                                    <li class="link">
                                        <span>Представления</span>
                                    </li>
                                </a>
                                <a href="">
                                    <li class="link">
                                        <span>Хранилище Удаленных Данных</span>
                                    </li>
                                </a>
                            </ul>
                        </li>
                        <a href="">
                            <li class="link">
                                <span>Зарегистрированные колонки</span>
                            </li>
                        </a>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="doc-common-content">
            <h3>Загрузка...</h3>
        </div>
    </div>
</div>

<?php echo \Build::execute()->js('documentation.build.min'); ?>