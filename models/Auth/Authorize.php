<?php

namespace Framework\Models\Auth;

use Framework\Models\Basic\Model;
use Framework\Helpers\Registration as RegistrationHelper;
use Framework\Modules\ORM;

/**
 * Class Auth
 * @package Framework\Components
 *
 * TODO
 * 1. Доработать логику
 * 2. Написать логирование ошибок
 * 3. Написать Ajax метод для js
 */
class Authorize extends Model
{
    protected function Process()
    {
        global $REQUEST;

        $user = $this->validate($REQUEST->arPost['username'], $REQUEST->arPost['password']);
        if ($user !== false) {
            $this->authorize($user['id'], $user['username']);
            $this->setStatus('success');
        }
    }

    /**
     * Метод авторизации пользователя
     * @param string $userId
     * @param string $username
     */
    private function authorize(string $userId, string $username)
    {
        global $USER;

        $USER->authorize($userId, $username);
    }

    /**
     * Функция валидации (существование и соответствие паролей)
     * @param string $username
     * @param string $password
     * @return array|mixed|string
     */
    private function validate(string $username, string $password)
    {
        $user = (new ORM('#users'))
            ->select(
                [
                    'id',
                    'username',
                ]
            )->where('username=:username')
            ->and('password=:password')
            ->execute(
                [
                    '#users' => $this->params['TABLE'],
                    ':username' => $username,
                    ':password' => RegistrationHelper::encryptPassword($password),
                ]
            );

        return (!empty($user) ? $user : false);
    }

}