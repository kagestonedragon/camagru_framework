<?php

namespace Framework\Models\Posts;
use Framework\Models\Basic\Model;
use Framework\Modules\Debugger;
use Framework\Modules\ORM;

class DeleteLike extends Model
{
    protected function process()
    {
        global $USER;
        global $REQUEST;

        echo '123';
        $userId = $USER->getId();
        $postId = $REQUEST->arGet['ID'];
        if ($this->validateDeletion($postId, $userId)) {
            $this->deleteLike($postId);
            $this->deleteConnection($postId, $userId);
        }
    }

    private function deleteConnection(string $postId, string $userId)
    {
        (new ORM('#connection'))
            ->delete()
            ->where('post_id=:post_id')
            ->and('user_id=:user_id')
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':post_id' => $postId,
                ':user_id' => $userId,
            ]);
    }

    private function deleteLike(string $postId)
    {
        (new ORM('#posts'))
            ->update([
                'likes ' => ' likes - 1',
            ])
            ->where('id=:post_id')
            ->execute([
                '#posts' => $this->params['TABLE'],
                ':post_id' => $postId,
            ]);
    }

    private function validateDeletion(string $postId, string $userId)
    {
        $result = (new ORM('#connection'))
            ->select([
                'id'
            ])
            ->where('post_id=:post_id')
            ->and('user_id=:user_id')
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':post_id' => $postId,
                ':user_id' => $userId,
            ]);

        return (!empty($result) ? true : false);
    }
}