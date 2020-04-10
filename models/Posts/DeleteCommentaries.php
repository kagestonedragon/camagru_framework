<?php

namespace Framework\Models\Posts;

use Framework\Models\Basic\Model;
use Framework\Modules\Debugger;
use Framework\Modules\ORM;

class DeleteCommentaries extends Model
{
    protected function process()
    {
        $ids = $this->getCommentariesIds($this->params['ITEM_ID']);
        if ($ids !== false) {
            $this->deleteCommentaries($ids);
            $this->deleteConnections($this->params['ITEM_ID']);
        }
    }

    protected function getCommentariesIds(string $itemId)
    {
        $result = (new ORM('#connection'))
            ->select([
                'commentary_id as id',
            ])
            ->where('post_id=:post_id')
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':post_id' => $itemId,
            ]);

        return (!empty($result) ? array_column($result, 'id') : false);
    }

    protected function deleteCommentaries(array $itemIds)
    {
        (new ORM('#commentaries'))
            ->delete()
            ->where('id')
            ->in($itemIds)
            ->execute([
                '#commentaries' => $this->params['TABLE'],
            ]);
    }

    protected function deleteConnections(string $itemId)
    {
        (new ORM('#connection'))
            ->delete()
            ->where('post_id=:post_id')
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':post_id' => $itemId,
            ]);
    }
}