<?php

namespace Framework\Models\Posts;
use Framework\Models\Basic\Model;
use Framework\Modules\ORM;

class DeleteCommentary extends Model
{
    protected function process()
    {
        global $USER;
        global $REQUEST;

        $commentaryId = $REQUEST->arGet['ID'];
        $userId = $USER->getId();
        if ($this->validateDeletion($commentaryId, $userId)) {
            $this->deleteCommentary($commentaryId);
            $this->deleteConnection($commentaryId);
        }
    }

    protected function validateDeletion(string $commentaryId, string $userId)
    {
        $result = (new ORM('#connection'))
            ->select([
                'id'
            ])
            ->where('commentary_id = :commentary_id')
            ->and('user_id = :user_id')
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':commentary_id' => $commentaryId,
                ':user_id' => $userId,
            ]);

        return (!empty($result) ? true : false);
    }

    protected function deleteCommentary(string $commentaryId)
    {
        (new ORM('#commentaries'))
            ->delete()
            ->where('id = :id')
            ->execute([
                '#commentaries' => $this->params['TABLE'],
                ':id' => $commentaryId,
            ]);
    }

    protected function deleteConnection(string $commentaryId)
    {
        (new ORM('#connection'))
            ->delete()
            ->where('commentary_id = :commentary_id')
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':commentary_id' => $commentaryId,
            ]);
    }
}