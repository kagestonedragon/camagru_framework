<?php

namespace Framework\Components;

use Framework\Helpers\Registration as RegistrationHelper;

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
        global $USER;
        global $APP;

        if ($USER->isAuthorized()) {
            $APP->Redirect('/site/');
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->isDataValid($_POST) && $this->isUserNotExists($_POST['username'], $_POST['email'])) {
                $this->addUser($_POST);
                echo "success";
            } else {
                echo 'KO';
            }
        }
    }


    /**
     * Метод валидации пришедших данных
     * @param array $data
     * @return bool
     */
    private function isDataValid(array $data)
    {
        if (empty($data) ||
            empty($data['username']) ||
            empty($data['password']) ||
            empty($data['email'])
        ) {
            $this->result['error'] = 'checkdata';
            return (false);
        } else {
            return (true);
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
        global $DB;

        $result = $DB->execute(
            'SELECT id FROM ' . $this->params['TABLE'] . ' WHERE username=:username OR email=:email',
            [
                ':username' => $username,
                ':email' => $email,
            ]
        );

        if (empty($result)) {
            return (true);
        } else {
            return (false);
        }
    }

    /**
     * Метод добавление нового пользователя
     * @param array $data
     */
    private function addUser(array $data)
    {
        global $DB;

        $result = $DB->execute(
            'INSERT INTO ' . $this->params['TABLE'] . ' (username, email, password, token) 
            VALUES (:username, :email, :password, :token)',
            [
                ':username' => $data['username'],
                ':email' => $data['email'],
                ':password' => RegistrationHelper::encryptPassword($data['password']),
                ':token' => RegistrationHelper::generateToken($data['username']),
            ]
        );
    }
}