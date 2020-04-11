<?php

namespace Framework\Models\Posts;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;

/**
 * Class AddLike
 * @package Framework\Models\Posts
 */
class AddLike extends Model
{
    protected function process()
    {
        global $USER;
        global $REQUEST;

        $userId = $USER->getId();
        $postId = $REQUEST->arGet['ID'];
        if ($this->validateLike($postId, $userId)) {
            $this->addLike($postId);
            $this->addConnection($postId, $userId);
        }
    }

    /**
     * Метод добавления лайка на фотографию
     * @param string $postId
     */
    private function addLike(string $postId)
    {
        (new ORM('#posts'))
            ->update([
                'likes ' => ' likes + 1',
            ])
            ->where('id=:post_id')
            ->execute([
                '#posts' => $this->params['TABLE'],
                ':post_id' => $postId,
            ]);
    }

    private function addConnection(string $postId, string $userId)
    {
        (new ORM('#connection'))
            ->insert([
                'user_id' => ':user_id',
                'post_id' => ':post_id',
            ])
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':user_id' => $userId,
                ':post_id' => $postId,
            ]);
    }

    /**
     * Метод валидации лайка (вдруг он уже есть?)
     * @param string $postId
     * @param string $userId
     * @return bool
     */
    private function validateLike(string $postId, string $userId)
    {
        $result = (new ORM('#connection'))
            ->select([
                'id'
            ])
            ->where('user_id=:user_id')
            ->and('post_id=:post_id')
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':user_id' => $userId,
                ':post_id' => $postId,
            ]);

        return (empty($result) ? true : false);
    }
}