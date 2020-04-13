<?php

namespace Framework\Controllers;

use Framework\Models\Registration\Register;

class Registration extends Controller
{
    const FORM = [
        'MODEL' => 'Registration::Register',
        'VIEW' => 'Registration.default',
    ];
    const VERIFICATION = [
        'MODEL' => 'Registration::Verificate',
        'VIEW' => 'Registration.verification',
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
            $this->registration(Registration::FORM['MODEL'], $params);
        } else if ($action == 'VERIFICATION') {
            $this->verification(Registration::VERIFICATION['MODEL'], Registration::VERIFICATION['VIEW'], $params);
        }
    }

    private function verification(string $model, string $view, array $params = [])
    {
        global $APPLICATION;

        $result = $APPLICATION->loadModel($model, $params);
        $APPLICATION->loadView($view, $result);
    }

    private function registration(string $model, array $params = [])
    {
        global $APPLICATION;
        global $REQUEST;

        $result = [];
        if ($REQUEST->getMethod() == 'POST') {
            $result = $APPLICATION->loadModel($model, $params);
        }

        if (isset($result['status']) && $result['status'] == Register::STATUS['SUCCESS']) {
            $APPLICATION->loadView(Registration::VERIFICATION['VIEW'], $result);
        } else {
            $APPLICATION->loadView(Registration::FORM['VIEW']);
        }
    }
}