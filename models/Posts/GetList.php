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
    const GET_LIKES = [
        'MODEL' => 'Posts::GetLikes',
    ];

    protected function process()
    {
        global $APPLICATION;
        global $USER;

        $this->result['ITEMS'] = $this->getItemsList();
        $itemIds = array_column($this->result['ITEMS'], 'id');
        $this->result['COMMENTARIES'] = $APPLICATION->loadModel(
            GetList::GET_COMMENTARIES['MODEL'],
            [
                'TABLE' => $this->params['TABLE_COMMENTARIES'],
                'TABLE_CONNECTION' => $this->params['TABLE_COMMENTARIES_CONNECTION'],
                'TABLE_USERS' => $this->params['TABLE_USERS'],
                'ITEMS_IDS' => $itemIds,
            ]
        );
        $likes = $APPLICATION->loadModel(
            GetList::GET_LIKES['MODEL'],
            [
                'TABLE_CONNECTION' => $this->params['TABLE_LIKES'],
                'ITEMS_IDS' => $itemIds,
            ]
        );
        PostsHelper::setLikeActions($this->result['ITEMS'], $likes, $USER->getId());
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
                '#posts.date',
                '#posts.likes',
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

        //Debugger::show($items);
        PostsHelper::generatePathToImages($items, GetList::IMAGE_DIRECTORY);
        return ($items);
    }

}