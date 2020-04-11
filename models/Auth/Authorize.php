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
    const STATUS = [
        'NOT_VALID_DATA' => 5200,
        'NOT_VERIFIED' => 5201,
        'SUCCESS' => 5202,
    ];

    protected function Process()
    {
        global $REQUEST;

        $user = $this->validate($REQUEST->arPost['username'], $REQUEST->arPost['password']);
        if (is_array($user)) {
            $this->authorize($user['id'], $user['username']);
            $this->setStatus(Authorize::STATUS['SUCCESS']);
        } else {
            $this->setStatus($user);
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
            ->select([
                    'id',
                    'username',
                    'verified',
            ])
            ->where('username=:username')
            ->and('password=:password')
            ->execute(
                [
                    '#users' => $this->params['TABLE'],
                    ':username' => $username,
                    ':password' => RegistrationHelper::encryptPassword($password),
                ]
            );

        if (empty($user)) {
            return (Authorize::STATUS['NOT_VALID_DATA']);
        } else if ($user['verified'] == '0') {
            return (Authorize::STATUS['NOT_VERIFIED']);
        } else {
            return ($user);
        }
    }

}