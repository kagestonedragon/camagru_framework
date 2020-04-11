<?php

/**
 * Запускаем сессию
 */
session_start();

/**
 * Константы
 */
require_once('include/constants/framework.php');
require_once('include/constants/site.php');

/**
 * Конфигурации
 */
require_once('include/config/database.php');
require_once('include/config/tables.php');
require_once('include/config/router.php');

/**
 * Автолоадер
 */
require_once('include/autoloader.php');

/**
 * Создание объектов модулей
 */
require_once('include/global_object.php');
