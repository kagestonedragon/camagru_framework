<?php

use Framework\Modules\Debugger;

$APP = new Framework\Modules\Application();
$DB = new Framework\Modules\Database($dbConfig);
$USER = new Framework\Modules\User();
$REQUEST = new Framework\Modules\Request();