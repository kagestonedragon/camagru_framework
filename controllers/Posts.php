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
        'VIEW' => 'Posts.new'
    ];

    protected function Process()
    {
        global $REQUEST;
        global $dbTables;

        $params = [
            'TABLE' => $dbTables['POSTS'],
            'TABLE_CONNECTION' => $dbTables['USERS_POSTS'],
            'TABLE_USERS' => $dbTables['USERS'],
        ];
        $action = $REQUEST->arGet['ACTION'];
        if ($action == 'SHOW_LIST') {
            $this->showList(Posts::SHOW_LIST['MODEL'], Posts::SHOW_LIST['VIEW'], $params);
        } else if ($action == 'SHOW_ITEM') {
            $this->showItem(Posts::SHOW_ITEM['MODEL'], Posts::SHOW_ITEM['VIEW'], $params);
        } else if ($action == "DELETE") {
            $this->deleteItem(Posts::DELETE_ITEM['MODEL'], $params);
        } else if ($action == "FORM") {
            $this->formItem(Posts::FORM_ITEM['MODEL'], Posts::FORM_ITEM['VIEW'], $params);
        }
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

        if (isset($result['STATUS']) && $result['STATUS'] == 'success') {
            $APPLICATION->Redirect("/items/");
        }

        $APPLICATION->loadView(
            $view,
            $result
        );
    }
}
