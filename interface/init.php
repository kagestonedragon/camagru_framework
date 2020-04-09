<?php

/**
 * Запускаем сессию
 */
session_start();

/**
 * Константы
 */
require_once('constants/framework.php');

/**
 * Конфигурации
 */
require_once('configuration/database.php');
require_once('configuration/tables.php');
require_once('configuration/router.php');

/**
 * Автолоадер
 */
require_once('initialization/autoloader.php');

/**
 * Создание объектов модулей
 */
require_once('initialization/objects.php');
//\Framework\Modules\Debugger::show($_SERVER['REQUEST_URI']);