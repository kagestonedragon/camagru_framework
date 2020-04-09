<?php

namespace Framework\Components;

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
class Auth extends Component
{
    protected function Process()
    {
        global $REQUEST;
        global $USER;
        global $APP;

        $requestMethod = $REQUEST->getMethod();
        if ($requestMethod == 'GET') {
            if (isset($REQUEST->arGet['logout'])) {
                $USER->endSession();
                $APP->Redirect('/site/');
            }
        } else if ($USER->isAuthorized()) {
            $APP->Redirect('/site/');
        } else if ($requestMethod == 'POST') {
            $this->Authorize($REQUEST->arPost['username'], $REQUEST->arPost['password']);
            $APP->Redirect('/site/');
        }
    }

    /**
     * Метод авторизации пользователя
     * @param string $username
     * @param string $password
     */
    private function Authorize(string $username, string $password)
    {
        global $USER;

        $user = $this->validate($username, $password);
        if (!empty($user)) {
            $USER->authorize($user['id'], $user['username']);
        }
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

        return ($user);
    }

}