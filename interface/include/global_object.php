<?php

use Framework\Modules\Debugger;

$APPLICATION = new \Framework\Modules\Application();
$DB = new \Framework\Modules\Database($dbConfig);
$USER = new \Framework\Modules\User();
$REQUEST = new \Framework\Modules\Request();
$ROUTER = new \Framework\Modules\Router($routerConfig, $_SERVER['REQUEST_URI']);