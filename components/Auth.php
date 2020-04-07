<?php

namespace Framework\Components;

use Framework\Helpers\Registration as RegistrationHelper;

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
        global $USER;
        global $APP;

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['logout'])) {
                $USER->endSession();
                $APP->Redirect('/site/');
            }
        } else if ($USER->isAuthorized()) {
            $APP->Redirect('/site/');
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->Authorize($_POST['username'], $_POST['password']);
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
        global $DB;

        $result = $DB->execute(
            'SELECT id, username, password FROM ' . $this->params['TABLE'] .
            ' WHERE username=:username AND password=:password',
            [
                'username' => $username,
                'password' => RegistrationHelper::encryptPassword($password),
            ]
        );

        if (!empty($result)) {
            $USER->authorize($result['id'], $result['username']);
        } else {
            echo '';
        }
    }

}