<?php

namespace Framework\Models\Posts;
use Framework\Models\Basic\Model;
use Framework\Modules\Debugger;
use Framework\Modules\ORM;
use Framework\Helpers\Posts as PostsHelper;

class GetLikes extends Model
{
    protected function process()
    {
        $this->result = $this->getLikes($this->params['ITEMS_IDS']);
    }

    private function getLikes(array $itemIds)
    {
        $result = (new ORM('#connection'))
            ->select([
                'user_id',
                'post_id',
            ])
            ->where('post_id')
            ->in($itemIds)
            ->execute([
                    '#connection' => $this->params['TABLE_CONNECTION'],
                ],
                false
            );

        $result = PostsHelper::sortLikesByPostId($result, $itemIds);
        return ($result);
    }
}
