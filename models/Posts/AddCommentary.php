<?php

namespace Framework\Models\Posts;

use Framework\Models\Basic\Model;
use Framework\Modules\ORM;

class AddCommentary extends Model
{
    protected function process()
    {
        global $REQUEST;
        global $USER;

        $itemId = $REQUEST->arGet['ID'];
        $userId = $USER->getId();
        $commentaryId = $this->addCommentary($itemId, $REQUEST->arPost['commentary']);
        $this->addConnection($userId, $itemId, $commentaryId);
        $this->result['id'] = $commentaryId;
        $this->result['item_id'] = $itemId;
    }

    private function addCommentary(string $itemId, string $text)
    {
        $id = (new ORM('#commentaries'))
            ->insert([
                'text' => ':text',
            ])
            ->execute([
               '#commentaries' => $this->params['TABLE'],
               ':text' => $text,
            ]);

        return ($id);
    }

    private function addConnection(string $userId, string $postId, string $commentaryId)
    {
        (new ORM('#users_commentaries'))
            ->insert([
                'user_id' => ':user_id',
                'post_id' => ':post_id',
                'commentary_id' => ':commentary_id',
            ])
            ->execute([
                '#users_commentaries' => $this->params['TABLE_CONNECTION'],
                ':user_id' => $userId,
                ':post_id' => $postId,
                ':commentary_id' => $commentaryId,
            ]);
    }

}