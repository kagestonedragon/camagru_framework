<?php

namespace Framework\Helpers;

class Registration
{
    const PASSWORD_HASH_ALGORITHM = 'md5';
    const TOKEN_HASH_ALGORITHM = 'md5';

    /**
     * Метод генерации токена
     * @param string $salt
     * @param string $algorithm
     * @return string
     */
    public static function generateToken(string $salt, string $algorithm = Registration::PASSWORD_HASH_ALGORITHM)
    {
        return (
            hash($algorithm, rand() . $salt)
        );
    }

    /**
     * Метод шифрования пароля
     * @param string $password
     * @param string $algorithm
     * @return string
     */
    public static function encryptPassword(string $password, string $algorithm = Registration::TOKEN_HASH_ALGORITHM)
    {
        return (
            hash($algorithm, $password)
        );
    }
}