<?php

namespace Framework\Models\Posts;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;

class DeleteLikes extends Model
{
    protected function process()
    {
        $this->deleteLikes($this->params['ITEM_ID']);
    }

    private function deleteLikes(string $postId)
    {
        (new ORM('#posts'))
            ->delete()
            ->where('id=:post_id')
            ->execute([
                '#posts' => $this->params['TABLE'],
                ':post_id' => $postId,
            ]);
    }
}