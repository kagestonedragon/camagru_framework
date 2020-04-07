<?php

namespace Framework\Modules;

/**
 * Class User
 * @package Framework\Modules
 *
 * TODO
 */
class User
{
    /**
     * Проверка на то авторизовани ли пользователь
     * @return bool
     */
    public function isAuthorized()
    {
        if (!empty($_SESSION['LOGGUED_ON_USER'])) {
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
            $_SESSION['LOGGUED_ON_USER'] = [
                'id' => $id,
                'username' => $username,
                'log_in_time' => date('d-m-Y h:i'),
            ];

            return (true);
        } else {
            return (false);
        }
    }

    /**
     * Метод завершения сессии
     */
    public function endSession()
    {
        if ($this->isAuthorized()) {
            $_SESSION['LOGGUED_ON_USER'] = null;

            session_destroy();
        }
    }

    public function getUsername()
    {
        if ($this->isAuthorized()) {
            return ($_SESSION['LOGGUED_ON_USER']['username']);
        }
    }

    public function getId()
    {
        if ($this->isAuthorized()) {
            return ($_SESSION['LOGGUED_ON_USER']['id']);
        }
    }
}
