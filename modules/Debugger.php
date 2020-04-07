<?php

namespace Framework\Modules;

/**
 * Class Debugger
 * @package Framework\Modules
 * Класс для дебага
 */
class Debugger
{
    public static function show($value, bool $isDie = true)
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';

        if ($isDie) {
            die();
        }
    }
}