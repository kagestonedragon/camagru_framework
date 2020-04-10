<?php
$routerConfig = [
    // POSTS
    [
        'PATTERN' => '/^(\/items\/)$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ACTION' => 'SHOW_LIST',
        ],
    ],
    [
        'PATTERN' => '/^(\/items\/)([0-9]+)\/$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ID' => 2,
            'ACTION' => 'SHOW_ITEM',
        ],
    ],
    [
        'PATTERN' => '/^(\/items\/add\/)$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ID' => 2,
            'ACTION' => 'FORM',
        ],
    ],
    [
        'PATTERN' => '/^(\/items\/delete\/)([0-9]+)\/$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ID' => 2,
            'ACTION' => 'DELETE',
        ],
    ],
    [
        'PATTERN' => '/^(\/items\/)([0-9]+)(\/commentaries\/add\/)$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ID' => 2,
            'ACTION' => 'COMMENTARY_ADD',
        ],
    ],
    [
        'PATTERN' => '/^(\/items\/)([0-9]+)(\/commentary\/)([0-9]+)(\/delete\/)$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ID' => 4,
            'ACTION' => 'COMMENTARY_DELETE',
        ],
    ],
    // AUTH
    [
        'PATTERN' => '/^(\/auth\/)$/',
        'LOCATION' => '/site/auth/index.php',
        'PARAMS' => [
            'ACTION' => 'FORM',
        ],
    ],
    [
        'PATTERN' => '/^(\/logout\/)$/',
        'LOCATION' => '/site/auth/index.php',
        'PARAMS' => [
            'ACTION' => 'LOGOUT',
        ],
    ],
    // REGISTRATION
    [
        'PATTERN' => '/^(\/registration\/)$/',
        'LOCATION' => '/site/registration/index.php',
        'PARAMS' => [
            'ACTION' => 'FORM',
        ],
    ],
];