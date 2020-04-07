<?php

namespace Framework\Modules;

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