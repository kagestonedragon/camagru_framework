<?php
$routerConfig = [
    [
        'PATTERN' => '/^(\/site\/items\/)$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ACTION' => 'SHOW_LIST',
        ],
    ],
    [
        'PATTERN' => '/^(\/site\/items\/)([0-9]+)\/$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ID' => 2,
            'ACTION' => 'SHOW_ITEM',
        ],
    ],
    [
        'PATTERN' => '/^(\/site\/items\/add\/)$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ID' => 2,
            'ACTION' => 'FORM',
        ],
    ],
    [
        'PATTERN' => '/^(\/site\/items\/delete\/)([0-9]+)\/$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ID' => 2,
            'ACTION' => 'DELETE',
        ],
    ],
];