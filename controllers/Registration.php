<?php

namespace Framework\Controllers;

class Registration extends Controller
{
    const FORM = [
        'MODEL' => 'Registration::Register',
        'VIEW' => 'Registration.default',
    ];
    const VERIFICATION = [
        'VIEW' => 'Registration.verification',
    ];

    protected function process()
    {
        global $APPLICATION;
        global $REQUEST;
        global $dbTables;

        $params = [
            'TABLE' => $dbTables['USERS'],
        ];
        $result = [];
        if ($REQUEST->getMethod() == 'POST') {
            $result = $APPLICATION->loadModel(Registration::FORM['MODEL'], $params);
        }

        if (isset($result['status']) == $result['status'] = 'verification') {
            $APPLICATION->loadView(Registration::VERIFICATION['VIEW'], $result);
        } else {
            $APPLICATION->loadView(Registration::FORM['VIEW']);
        }
    }
}