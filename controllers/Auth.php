<?php

namespace Framework\Controllers;

use Framework\Models\Auth\Authorize;

/**
 * Class Auth
 * @package Framework\Controllers
 */
class Auth extends Controller
{
    /**
     * Константы для моделей и названий шаблонов
     */
    const FORM = [
        'MODEL' => 'Auth::Authorize',
        'VIEW' => 'Auth.default',
    ];
    const LOGOUT = [
        'MODEL' => 'Auth::Logout',
    ];

    protected function process()
    {
        global $APPLICATION;
        global $REQUEST;
        global $dbTables;
        global $USER;

        if ($USER->isAuthorized()) {
            $APPLICATION->Redirect('/items/');
        }
        $params = [
            'TABLE' => $dbTables['USERS'],
        ];
        $action = $REQUEST->arGet['ACTION'];
        if ($action == 'FORM') {
            $this->form(Auth::FORM['MODEL'], Auth::FORM['VIEW'], $params);
        } else if ($action == 'LOGOUT') {
            $this->logout(Auth::LOGOUT['MODEL']);
        }
    }

    /**
     * Метод контроллера, отвечающий за обработку страницы с формой
     * @param string $model
     * @param string $view
     * @param array $params
     */
    private function form(string $model, string $view, array $params)
    {
        global $REQUEST;
        global $APPLICATION;

        $result = [];
        if ($REQUEST->getMethod() == 'POST') {
            $result = $APPLICATION->loadModel($model, $params);
        }

        if (isset($result['status']) && $result['status'] == Authorize::STATUS["SUCCESS"]) {
            $APPLICATION->Redirect('/items/');
        }

        $APPLICATION->loadView($view, $result);
    }

    /**
     * Метод контроллера, отвечающий за обработку логаута пользователя
     * @param string $model
     */
    private function logout(string $model)
    {
        global $APPLICATION;

        $APPLICATION->loadModel($model);
        $APPLICATION->Redirect('/auth/');
    }
}
