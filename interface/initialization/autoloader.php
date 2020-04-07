<?php

function autoloader($class)
{
    $class = explode('\\', $class);
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