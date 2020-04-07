<?php

namespace Framework\Helpers;

class Database
{
    /**
     * Метод получения первого параментра для создания объекта PDO (destination)
     * @param string $host
     * @param string $dbname
     * @return string
     */
    public static function getDestination(string $host, string $dbname)
    {
        return (
            implode(
                ';',
                [
                    'mysql:host=' . $host,
                    'dbname=' . $dbname,
                ]
            )
        );
    }
}