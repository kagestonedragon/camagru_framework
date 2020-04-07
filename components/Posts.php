<?php

namespace Framework\Components;

use Framework\Helpers\Posts as PostsHelper;
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
class Posts extends Component
{
    const IMAGES_DIR = '/framework/upload/';

    protected function Process()
    {
        global $REQUEST;
        global $USER;
        global $APP;

        if (!$USER->isAuthorized()) {
            $APP->Redirect('/site/auth');
        }

        $requestMethod = $REQUEST->getMethod();
        if ($requestMethod == 'GET') {
            if (isset($REQUEST->arGet['post']) && isset($REQUEST->arGet['delete'])) {
                $this->deleteItem($REQUEST->arGet['post'], $USER->getId());
            }
        } else if ($requestMethod == 'POST') {
            $filename = File::upload(
                $USER->getId(),
                $REQUEST->arFiles['image_file']['name'],
                $REQUEST->arFiles['image_file']['type'],
                $REQUEST->arFiles['image_file']['tmp_name']
            );
            if ($filename !== false) {
                $this->addItem($filename, $_POST['description'], $USER->getId());
            }
        }

        $this->result['ITEMS'] = $this->getItemsList();
    }

    /**
     * Метод добавления нового поста
     * @param string $image
     * @param string $description
     * @param string $userId
     */
    private function addItem(string $image, string $description, string $userId)
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
        $this->addConnection(
            $id,
            $userId
        );
    }

    /**
     * Метод связывания юзера и пост при добавлении
     * @param string $postId
     * @param string $userId
     */
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
     * Получение списка постов
     */
    private function getItemsList()
    {
        $items = (new ORM('#posts'))
            ->select([
                    '#posts.id',
                    '#users.username',
                    '#users.id as user_id',
                    '#posts.image',
                    '#posts.description',
                    '#posts.date'
            ])
            ->left('#connection', '#posts.id=#connection.post_id')
            ->left('#users', '#connection.user_id=#users.id')
            ->order(
                '#posts.date',
                'DESC'
            )->execute([
                    '#posts' => $this->params['TABLE'],
                    '#users' => $this->params['TABLE_USERS'],
                    '#connection' => $this->params['TABLE_CONNECTION'],
                ],
                false
            );


        PostsHelper::generatePathToImages($items, Posts::IMAGES_DIR);
        return ($items);
    }

    /**
     * Метод удаления поста
     * @param string $postId
     * @param string $userId
     */
    private function deleteItem(string $postId, string $userId)
    {
        if (($filename = $this->validateDeletion($postId, $userId))) {
            // удаление из основной таблицы
            (new ORM('#posts'))
                ->delete()
                ->where('id=:post_id')
                ->execute([
                    '#posts' => $this->params['TABLE'],
                    ':post_id' => $postId,
                ]);
            // удаление из таблицы связи
            $this->deleteConnection($postId);
            // удаляем файл с изображением
            File::delete($userId, $filename);
        }
    }

    /**
     * Метод удаляения связи
     * @param string $postId
     */
    private function deleteConnection(string $postId)
    {
        (new ORM('#connection'))
            ->delete()
            ->where('post_id=:post_id')
            ->execute([
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':post_id' => $postId,
            ]);
    }

    /**
     * Метод валидации при удалении (является ли юзер автором поста)
     * @param string $postId
     * @param string $userId
     * @return bool|mixed
     */
    private function validateDeletion(string $postId, string $userId)
    {
        $result = (new ORM('#posts'))
            ->select([
                '#posts.image'
            ])
            ->left('#connection', '#posts.id=#connection.post_id')
            ->where('#posts.id=:post_id')
            ->and('#connection.user_id=:user_id')
            ->execute([
                '#posts' => $this->params['TABLE'],
                '#connection' => $this->params['TABLE_CONNECTION'],
                ':post_id' => $postId,
                ':user_id' => $userId,
            ]);

        return (
            !empty($result) ? $result['image'] : false
        );
    }
}