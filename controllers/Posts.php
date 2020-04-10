<?php

namespace Framework\Controllers;

class Posts extends Controller
{
    const SHOW_LIST = [
        'MODEL' => 'Posts::GetList',
        'VIEW' => 'Posts.list',
    ];
    const SHOW_ITEM = [
        'MODEL' => 'Posts::GetList',
        'VIEW' => 'Posts.item',
    ];
    const DELETE_ITEM = [
        'MODEL' => 'Posts::DeleteItem',
    ];
    const FORM_ITEM = [
        'MODEL' => 'Posts::AddItem',
        'VIEW' => 'Posts.photo'
    ];
    const COMMENTARY_ADD = [
        'MODEL' => 'Posts::AddCommentary',
    ];
    const COMMENTARY_DELETE = [
        'MODEL' => 'Posts::DeleteCommentary',
    ];

    protected function Process()
    {
        global $USER;
        global $REQUEST;
        global $dbTables;
        global $APPLICATION;

        if (!$USER->isAuthorized()) {
            $APPLICATION->Redirect('/auth/');
        }

        $itemParams = [
            'TABLE' => $dbTables['POSTS'],
            'TABLE_CONNECTION' => $dbTables['USERS_POSTS'],
            'TABLE_USERS' => $dbTables['USERS'],
            'TABLE_COMMENTARIES' => $dbTables['COMMENTARIES'],
            'TABLE_COMMENTARIES_CONNECTION' => $dbTables['USERS_POSTS_COMMENTARIES'],
        ];
        $commentaryParam = [
            'TABLE' => $dbTables['COMMENTARIES'],
            'TABLE_CONNECTION' => $dbTables['USERS_POSTS_COMMENTARIES'],
        ];
        $action = $REQUEST->arGet['ACTION'];
        if ($action == 'SHOW_LIST') {
            $this->showList(Posts::SHOW_LIST['MODEL'], Posts::SHOW_LIST['VIEW'], $itemParams);
        } else if ($action == 'SHOW_ITEM') {
            $this->showItem(Posts::SHOW_ITEM['MODEL'], Posts::SHOW_ITEM['VIEW'], $itemParams);
        } else if ($action == "DELETE") {
            $this->deleteItem(Posts::DELETE_ITEM['MODEL'], $itemParams);
        } else if ($action == "FORM") {
            $this->formItem(Posts::FORM_ITEM['MODEL'], Posts::FORM_ITEM['VIEW'], $itemParams);
        } else if ($action == 'COMMENTARY_ADD') {
            $this->addCommentary(Posts::COMMENTARY_ADD['MODEL'], $commentaryParam);
        } else if ($action == 'COMMENTARY_DELETE') {
            $this->deleteCommentary(Posts::COMMENTARY_DELETE['MODEL'], $commentaryParam);
        }
    }

    private function addCommentary(string $model, array $params = [])
    {
        global $APPLICATION;

        $APPLICATION->loadModel($model, $params);
        $APPLICATION->Redirect('/items/');
    }

    private function deleteCommentary(string $model, array $params = [])
    {
        global $APPLICATION;

        $APPLICATION->loadModel($model, $params);
        $APPLICATION->Redirect('/items/');
    }

    private function showList(string $model, string $view, array $params = [])
    {
        global $APPLICATION;

        $APPLICATION->loadView(
            $view,
            $APPLICATION->loadModel($model, $params)
        );
    }

    private function showItem(string $model, string $view, array $params = [])
    {
        global $APPLICATION;

        $APPLICATION->loadView(
            $view,
            $APPLICATION->loadModel($model, $params)
        );
    }

    private function deleteItem(string $model, array $params = [])
    {
        global $APPLICATION;

        $APPLICATION->loadModel($model, $params);
        $APPLICATION->Redirect("/items/");
    }

    private function formItem(string $model, string $view, array $params = [])
    {
        global $APPLICATION;
        global $REQUEST;

        $result = [];
        if ($REQUEST->getMethod() == 'POST') {
            $result = $APPLICATION->loadModel($model, $params);
        }

        if (isset($result['status']) && $result['status'] == 'success') {
            $APPLICATION->Redirect("/items/");
        }

        $APPLICATION->loadView(
            $view,
            $result
        );
    }
}
