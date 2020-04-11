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
class AddItem extends Model
{
    protected function process()
    {
        global $REQUEST;
        global $USER;

        if ($REQUEST->getMethod() == 'POST') {
            $userId = $USER->getId();
            $filename = File::upload(
                $userId,
                $REQUEST->arFiles['image_file']['name'],
                $REQUEST->arFiles['image_file']['type'],
                $REQUEST->arFiles['image_file']['tmp_name']
            );
            if ($filename !== false) {
                $itemId = $this->addItem($filename, $_POST['description']);
                $this->addConnection($itemId, $userId);
                $this->setStatus('success');
            }
        }
    }

    /**
     * Метод добавления нового поста
     * @param string $image
     * @param string $description
     * @return array|mixed|string
     */
    private function addItem(string $image, string $description)
    {
        $id = (new ORM('#posts'))
            ->insert([
                'image' => ':image',
                'description' => ':description',
            ])->
            execute([
                '#posts' => $this->params['TABLE'],
                ':image' => $image,
                ':description' => $description,
            ]);

        return ($id);
    }

    /**
     * Метод связывания юзера и пост при добавлении
     * @param string $itemId
     * @param string $userId
     */
    private function addConnection(string $itemId, string $userId)
    {
        (new ORM('#connection'))
            ->insert([
                'user_id' => ':user_id',
                'post_id' => ':post_id',
            ])
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':user_id' => $userId,
                ':post_id' => $itemId,
            ]);
    }
}