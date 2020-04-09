<?php

namespace Framework\Modules;

/**
 * Class User
 * @package Framework\Modules
 * Основной модуль для работы с данными пользователя
 */
class User
{
    /**
     * Проверка на то авторизовани ли пользователь
     * @return bool
     */
    public function isAuthorized()
    {
        if (!empty($_SESSION['AUTHORIZED_USER'])) {
            return (true);
        } else {
            return (false);
        }
    }

    /**
     * Метод авторизации пользователя на сайте
     * @param string $id
     * @param string $username
     * @return bool
     */
    public function authorize(string $id, string $username)
    {
        if (!$this->isAuthorized()) {
            $_SESSION['AUTHORIZED_USER'] = [
                'ID' => $id,
                'USERNAME' => $username,
                'AUTH_TIME' => date('d-m-Y h:i'),
            ];

            return (true);
        } else {
            return (false);
        }
    }

    /**
     * Метод завершения сессии
     */
    public function logout()
    {
        if ($this->isAuthorized()) {
            $_SESSION['AUTHORIZED_USER'] = null;

            session_destroy();
        }
    }

    /**
     * метод получения имени пользователя
     * @return mixed
     */
    public function getUsername()
    {
        if ($this->isAuthorized()) {
            return ($_SESSION['AUTHORIZED_USER']['USERNAME']);
        }
    }

    /**
     * Метод получения id пользователя
     * @return mixed
     */
    public function getId()
    {
        if ($this->isAuthorized()) {
            return ($_SESSION['AUTHORIZED_USER']['ID']);
        }
    }
}
