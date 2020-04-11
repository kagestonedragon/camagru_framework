<?php

namespace Framework\Models\Posts;

use Framework\Models\Basic\Model;
use Framework\Modules\ORM;
use Framework\Modules\File;

/**
 * Class Posts
 * @package Framework\Components
 *
 * TODO
 * 1. Написать кеширование запросов
 * 4. Добавить возможности редактировать пост и удалить
 */
class DeleteItem extends Model
{
    const COMMENTARIES_DELETE = [
        'MODEL' => 'Posts::DeleteCommentaries',
    ];
    const LIKES_DELETE = [
        'MODEL' => 'Posts::DeleteLikes',
    ];

    protected function Process()
    {
        global $APPLICATION;
        global $REQUEST;
        global $USER;

        $itemId = $REQUEST->arGet['ID'];
        $userId = $USER->getId();
        if (!empty($itemId)) {
            $filename = $this->validateDeletion($itemId, $userId);

            if ($filename !== false) {
                $this->deleteItem($itemId, $userId);
                $this->deleteConnection($itemId);
                File::delete($userId, $filename);
                $APPLICATION->loadModel(
                    DeleteItem::COMMENTARIES_DELETE['MODEL'],
                    [
                        'TABLE' => $this->params['TABLE_COMMENTARIES'],
                        'TABLE_CONNECTION' => $this->params['TABLE_COMMENTARIES_CONNECTION'],
                        'ITEM_ID' => $itemId,
                    ]
                );
                $APPLICATION->loadModel(
                    DeleteItem::LIKES_DELETE['MODEL'],
                    [
                        'TABLE' => $this->params['TABLE'],
                        'ITEM_ID' => $itemId,
                    ]
                );
            }
        }
    }

    /**
     * Метод удаления поста
     * @param string $itemId
     * @param string $userId
     */
    private function deleteItem(string $itemId, string $userId)
    {
        // удаление из основной таблицы
        (new ORM('#posts'))
            ->delete()
            ->where('id=:post_id')
            ->execute([
                '#posts' => $this->params['TABLE'],
                ':post_id' => $itemId,
            ]);
    }

    /**
     * Метод удаляения связи
     * @param string $itemId
     */
    private function deleteConnection(string $itemId)
    {
        (new ORM('#connection'))
            ->delete()
            ->where('post_id=:post_id')
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':post_id' => $itemId,
            ]);
    }

    /**
     * Метод валидации при удалении (является ли юзер автором поста)
     * @param string $itemId
     * @param string $userId
     * @return bool|mixed
     */
    private function validateDeletion(string $itemId, string $userId)
    {
        $item = (new ORM('#posts'))
            ->select([
                '#posts.image'
            ])
            ->left('#connection', '#posts.id=#connection.post_id')
            ->where('#posts.id=:post_id')
            ->and('#connection.user_id=:user_id')
            ->execute([
                '#posts' => $this->params['TABLE'],
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':post_id' => $itemId,
                ':user_id' => $userId,
            ]);

        return (!empty($item) ? $item['image'] : false);
    }
}