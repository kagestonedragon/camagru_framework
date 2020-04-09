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
require_once('config/database.php');
require_once('config/tables.php');
require_once('config/router.php');

/**
 * Автолоадер
 */
require_once('initialization/autoloader.php');

/**
 * Создание объектов модулей
 */
require_once('initialization/objects.php');
//\Framework\Modules\Debugger::show($_SERVER['REQUEST_URI']);