<?php

namespace Framework\Components;

use Framework\Helpers\Registration as RegistrationHelper;
use Framework\Modules\ORM;

/**
 * Class Registration
 * @package Framework\Components
 *
 * TODO
 * 1. Дописать метод отправки письма с подтверждением на почту
 * 2. Метод для ajax обработки
 * 3. Метод подтверждения регистрации
 */
class Registration extends Component
{
    protected function Process()
    {
        global $REQUEST;
        global $USER;
        global $APP;

        $requestMethod = $REQUEST->getMethod();
        if ($USER->isAuthorized()) {
            $APP->Redirect('/site/');
        } else if ($requestMethod == 'POST') {
            if ($this->isUserNotExists($REQUEST->arPost['username'], $REQUEST->arPost['email'])) {
                $this->addUser(
                    $REQUEST->arPost['username'],
                    $REQUEST->arPost['email'],
                    $REQUEST->arPost['password']
                );
            }
        }
    }

    /**
     * Метод проверки пользователя на существование
     * @param string $username
     * @param string $email
     * @return bool
     */
    private function isUserNotExists(string $username, string $email)
    {
        $user = (new ORM('#users'))
            ->select([
                    'id'
            ])
            ->where('username=:username')
            ->or('email=:email')
            ->execute([
                '#users' => $this->params['TABLE'],
                ':username' => $username,
                ':email' => $email,
            ]);

        return (
            empty($user) ? true : false
        );
    }

    /**
     * Метод добавление нового пользователя
     * @param string $username
     * @param string $email
     * @param string $password
     */
    private function addUser(string $username, string $email, string $password)
    {
        (new ORM('#users'))
            ->insert([
                'username' => ':username',
                'email' => ':email',
                'password' => ':password',
                'token' => ':token',
            ])
            ->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => RegistrationHelper::encryptPassword($password),
                ':token' => RegistrationHelper::generateToken($username),
            ]);
    }
}