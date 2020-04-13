<?php

namespace Framework\Controllers;
use Framework\Controllers\Controller;

/**
 * Class Ajax
 * @package Framework\Controllers
 *
 * TODO
 * Написать ajax модель для запроса
 * Написать получение данных на фронте
 */
class Ajax extends Controller
{
    const ADD_COMMENTARY = [
        'MODEL' => 'Posts::AddCommentary',
    ];
    const GET_ITEMS = [
        'MODEL' => 'Posts::GetList',
    ];

    protected function process()
    {
        global $REQUEST;

        $action = $REQUEST->arGet['ACTION'];
        if ($action == 'COMMENTARY_ADD') {
            $this->addCommentary(Ajax::ADD_COMMENTARY['MODEL']);
        } else if ($action == 'GET_ITEMS') {
            $this->getItems(Ajax::GET_ITEMS['MODEL']);
        }
    }

    private function addCommentary(string $model)
    {
        global $APPLICATION;
        global $dbTables;

        $params = [
            'TABLE' => $dbTables['COMMENTARIES'],
            'TABLE_CONNECTION' => $dbTables['USERS_POSTS_COMMENTARIES'],
        ];
        $result = $APPLICATION->loadModel($model, $params);

        echo json_encode($result);
    }

    private function getItems(string $model)
    {
        global $APPLICATION;
        global $dbTables;

        $params = [
            'TABLE' => $dbTables['POSTS'],
            'TABLE_CONNECTION' => $dbTables['USERS_POSTS'],
            'TABLE_USERS' => $dbTables['USERS'],
            'TABLE_COMMENTARIES' => $dbTables['COMMENTARIES'],
            'TABLE_COMMENTARIES_CONNECTION' => $dbTables['USERS_POSTS_COMMENTARIES'],
            'TABLE_LIKES' => $dbTables['USERS_POSTS_LIKES'],
        ];

        $result = $APPLICATION->loadModel($model, $params);

        echo json_encode($result);

    }
}