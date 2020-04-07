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

/**
 * Автолоадер
 */
require_once('initialization/autoloader.php');

/**
 * Создание объектов модулей
 */
require_once('initialization/objects.php');