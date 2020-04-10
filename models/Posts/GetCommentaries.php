<?php

namespace Framework\Models\Posts;
use Framework\Models\Basic\Model;
use Framework\Helpers\Posts as PostsHelper;
use Framework\Modules\Debugger;
use Framework\Modules\ORM;

class GetCommentaries extends Model
{
    protected function process()
    {
        $this->result = $this->getCommentaries($this->params['ITEMS_IDS']);
    }

    private function getCommentaries(array $itemsIds)
    {
        $commentaries = (new ORM('#commentaries'))
            ->select([
                '#commentaries.id',
                '#commentaries.text as commentary',
                '#connection.post_id',
                '#connection.user_id',
                '#users.username',
            ])
            ->left(
                '#connection',
                '#commentaries.id=#connection.commentary_id'
            )
            ->left(
                '#users',
                '#users.id=#connection.user_id'
            )
            ->where('#connection.post_id')
            ->in($itemsIds)
            ->order('#commentaries.id',
                'ASC')
            ->execute([
                    '#commentaries' => $this->params['TABLE'],
                    '#connection' => $this->params['TABLE_CONNECTION'],
                    '#users' => $this->params['TABLE_USERS'],
                ],
                false
            );

        $commentaries = PostsHelper::sortCommentariesByPostId($commentaries, $itemsIds);

        return ($commentaries);
    }
}