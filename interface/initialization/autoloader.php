<?php

function autoloader($class)
{
    $class = explode('\\', strtolower($class));
    require_once(
        implode(
            '/',
            [
                $_SERVER['DOCUMENT_ROOT'],
                $class[0],
                $class[1],
                ucfirst($class[2]) . '.php',
            ]
        )
    );
}

spl_autoload_register('autoloader');