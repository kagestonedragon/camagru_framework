<?php

function autoloader($class)
{
    $class = explode('\\', $class);

    switch ($class[1]) {
        case 'Models':
            loadModels($class);
            break;
        case 'Modules':
            loadModules($class);
            break;
        case 'Helpers':
            loadHelpers($class);
            break;
        case 'Controllers':
            loadController($class);
            break;
    }
}

/**
 * Подгрузка моделей
 * @@noinspection PhpIncludeInspection
 * @param $class
 */
function loadModels($class)
{
    require_once(
        implode(
            '/',
            [
                $_SERVER['DOCUMENT_ROOT'],
                strtolower($class[0]),
                strtolower($class[1]),
                $class[2],
                $class[3] . '.php',
            ]
        )
    );
}

/**
 * Подгрузка модулей
 * @@noinspection PhpIncludeInspection
 * @param $class
 */
function loadModules($class)
{
    require_once(
        implode(
            '/',
            [
                $_SERVER['DOCUMENT_ROOT'],
                strtolower($class[0]),
                strtolower($class[1]),
                $class[2] . '.php',
            ]
        )
    );
}

/**
 * Подгрузка контроллера
 * @@noinspection PhpIncludeInspection
 * @param $class
 */
function loadController($class)
{
    require_once(
        implode(
            '/',
            [
                $_SERVER['DOCUMENT_ROOT'],
                strtolower($class[0]),
                strtolower($class[1]),
                $class[2] . '.php',
            ]
        )
    );
}

/**
 * Подгрузка хелперов
 * @@noinspection PhpIncludeInspection
 * @param $class
 */
function loadHelpers($class)
{
    require_once(
    implode(
        '/',
        [
            $_SERVER['DOCUMENT_ROOT'],
            strtolower($class[0]),
            strtolower($class[1]),
            $class[2] . '.php',
        ]
    )
    );
}

spl_autoload_register('autoloader');