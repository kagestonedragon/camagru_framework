<?php

namespace Framework\Helpers;

class ORM
{
    public static function getUpdateValues(array $values)
    {
        foreach ($values as $key => $value) {
            $values[$key] = $key . '=' . $value;
        }

        return (implode(',', $values));
    }
}