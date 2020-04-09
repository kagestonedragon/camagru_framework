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
        // DELETE POST RULE
        'PATTERN' => '/^(\/items\/delete\/)([0-9]+)\/$/',
        'LOCATION' => '/site/items/index.php',
        'PARAMS' => [
            'ID' => 2,
            'ACTION' => 'DELETE',
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
    ]
];