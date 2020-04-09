<?php

namespace Framework\Controllers;

use Framework\Modules\Debugger;
use Framework\Modules\File;
use Framework\Modules\ORM;

class Posts extends Controller
{
    protected function Process()
    {
        global $APP;
        global $REQUEST;

        $action = $REQUEST->arGet['ACTION'];
        $params = [
            'TABLE' => $this->params['TABLE'],
            'TABLE_CONNECTION' => $this->params['TABLE_CONNECTION'],
            'TABLE_USERS' => $this->params['TABLE_USERS'],
        ];
        if ($action == 'SHOW_LIST') {
            $APP->useComponent(
                'Posts:ItemsList',
                'default',
                $params
            );
        } else if ($action == 'SHOW_ITEM') {
            $APP->useComponent(
                'Posts:Item',
                'item',
                $params
            );
        } else if ($action == "DELETE") {
            $APP->useComponent(
                'Posts:DeleteItem',
                'default',
                $params
            );
        } else if ($action == "FORM") {
            $APP->useComponent(
                'Posts:AddItem',
                'new_upload',
                $params
            );
        }
    }
}
