<?php

namespace Framework\Components\Posts;

use Framework\Components\Basic\Component;
use Framework\Helpers\Posts as PostsHelper;
use Framework\Modules\Debugger;
use Framework\Modules\ORM;

/**
 * Class Posts
 * @package Framework\Components
 *
 * TODO
 * 1. Написать кеширование запросов
 * 4. Добавить возможности редактировать пост и удалить
 */
class ItemsList extends Component
{
    const IMAGES_DIR = '/framework/upload/';

    protected function Process()
    {
        $this->result['ITEMS'] = $this->getItemsList();
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


        PostsHelper::generatePathToImages($items, ItemsList::IMAGES_DIR);
        return ($items);
    }

}