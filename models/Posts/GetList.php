<?php

namespace Framework\Models\Posts;

use Framework\Models\Basic\Model;
use Framework\Helpers\Posts as PostsHelper;
use Framework\Modules\Debugger;
use Framework\Modules\ORM;

/**
 * Class GetList
 * @package Framework\Models\Posts
 */
class GetList extends Model
{
    const IMAGE_DIRECTORY = '/' . FW_NAME . '/' . FW_UPLOAD . '/';
    const GET_COMMENTARIES = [
        'MODEL' => 'Posts::GetCommentaries',
    ];

    protected function Process()
    {
        global $APPLICATION;

        $this->result['ITEMS'] = $this->getItemsList();
        $this->result['COMMENTARIES'] = $APPLICATION->loadModel(
            GetList::GET_COMMENTARIES['MODEL'],
            [
                'TABLE' => $this->params['TABLE_COMMENTARIES'],
                'TABLE_CONNECTION' => $this->params['TABLE_COMMENTARIES_CONNECTION'],
                'TABLE_USERS' => $this->params['TABLE_USERS'],
                'ITEMS_IDS' => array_column($this->result['ITEMS'], 'id')
            ]
        );
        //
        //Debugger::show($this->result['ITEMS']);
    }

    /**
     * Получение списка постов
     */
    private function getItemsList()
    {
        $items = (new ORM('#posts'))
            ->select([
                '#posts.id',
                '#users.username',
                '#users.id as user_id',
                '#posts.image',
                '#posts.description',
                '#posts.date'
            ])
            ->left('#connection', '#posts.id=#connection.post_id')
            ->left('#users', '#connection.user_id=#users.id')
            ->order(
                '#posts.date',
                'DESC'
            )->execute([
                '#posts' => $this->params['TABLE'],
                '#users' => $this->params['TABLE_USERS'],
                '#connection' => $this->params['TABLE_CONNECTION'],
            ],
                false
            );

        PostsHelper::generatePathToImages($items, GetList::IMAGE_DIRECTORY);
        return ($items);
    }

}