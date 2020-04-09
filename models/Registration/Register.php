<?php

namespace Framework\Models\Registration;

use Framework\Helpers\Registration as RegistrationHelper;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;

class Register extends Model
{
    protected function Process()
    {
        global $REQUEST;

        if ($this->isUserNotExists($REQUEST->arPost['username'], $REQUEST->arPost['email'])) {
            $this->addUser(
                $REQUEST->arPost['username'],
                $REQUEST->arPost['email'],
                $REQUEST->arPost['password']
            );

            $this->result['email'] = $REQUEST->arPost['email'];
            $this->setStatus('verification');
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

        return (empty($user) ? true : false);
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
                '#users' => $this->params['TABLE'],
                ':username' => $username,
                ':email' => $email,
                ':password' => RegistrationHelper::encryptPassword($password),
                ':token' => RegistrationHelper::generateToken($username),
            ]);
    }
}