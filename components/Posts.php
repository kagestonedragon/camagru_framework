<?php

namespace Framework\Components;

use Framework\Helpers\Posts as PostsHelper;
use Framework\Modules\Debugger;
use Framework\Modules\Image;

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
    protected function Process()
    {
        global $USER;
        global $APP;

        if (!$USER->isAuthorized()) {
            $APP->Redirect('/site/auth');
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['post']) && isset($_GET['delete'])) {
                $this->deletePost($_GET['post']);
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (($filename = PostsHelper::uploadFile($_FILES['image_file'], $USER->getId()))) {
                Image::addTemplate(
                    FW_UPLOAD . '/1/' . $filename,
                    FW_UPLOAD . '/templates/png-file-6-1.png',
                    $filename
                );
                $this->addPost($filename, $_POST['description']);
            }
        }

        $this->result['ITEMS'] = $this->getPostsList();
    }

    private function copyFile()
    {
        if (!empty($_FILES)) {
            copy($_FILES['image_file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/framework/upload/test.jpg');
        }
    }
    /**
     * Метод добавления нового поста
     * @param string $image
     * @param string $description
     */
    private function addPost(string $image, string $description)
    {
        global $DB;
        global $USER;

        $DB->execute(
            'INSERT INTO ' . $this->params['TABLE'] .' (image, description) VALUES (:image, :description)',
            [
                'image' => $image,
                'description' => $description,
            ]
        );
        $this->addConnectionUserPost(
            $DB->getLastInsertedId($this->params['TABLE']),
            $USER->getId()
        );
    }

    /**
     * Метод связывания юзера и пост при добавлении
     * @param string $postId
     * @param string $userId
     */
    private function addConnectionUserPost(string $postId, string $userId)
    {
        global $DB;

        $DB->execute(
            'INSERT INTO ' . $this->params['TABLE_CONNECTION'] . '(user_id, post_id) VALUES (:user_id, :post_id)',
            [
                'user_id' => $userId,
                'post_id' => $postId,
            ]
        );
    }

    /**
     * Получение списка постов
     */
    private function getPostsList()
    {
        global $DB;

        /*
        SELECT posts.id, users.username, posts.image, posts.description, posts.date FROM posts
            LEFT JOIN users_posts ON posts.id=users_posts.post_id
            LEFT JOIN users ON users_posts.user_id=users.id ORDER BY posts.date DESC
        */
        $result = $DB->execute(
            'SELECT ' .
            $this->params['TABLE'] . '.id, ' .
            $this->params['TABLE_USERS'] . '.username, ' .
            $this->params['TABLE_USERS'] . '.id as user_id, ' .
            $this->params['TABLE'] . '.image, ' .
            $this->params['TABLE'] . '.description, ' .
            $this->params['TABLE'] . '.date ' .
            'FROM ' . $this->params['TABLE'] . ' ' .
            'LEFT JOIN ' . $this->params['TABLE_CONNECTION'] .
            ' ON ' . $this->params['TABLE'] . '.id=' . $this->params['TABLE_CONNECTION'] . '.post_id ' .
            'LEFT JOIN ' . $this->params['TABLE_USERS'] .
            ' ON ' . $this->params['TABLE_CONNECTION'] . '.user_id=' . $this->params['TABLE_USERS'] . '.id ' .
            'ORDER BY ' . $this->params['TABLE'] . '.date DESC',
            [],
            false
        );

        foreach ($result as $itemKey => $itemValue) {
            $result[$itemKey]['image'] = '/framework/upload/' . $itemValue['user_id'] . '/' . $itemValue['image'];
        }
        return ($result);
    }

    private function deletePost(string $postId)
    {
        global $DB;
        global $USER;

        if (($filename = $this->isPostAuthor($postId, $USER->getId()))) {
            // удаление из основной таблицы
            $DB->execute(
                'DELETE FROM ' . $this->params['TABLE'] . ' ' .
                'WHERE id=' . $postId
            );
            // удаление из таблицы связи
            $DB->execute(
                'DELETE FROM ' . $this->params['TABLE_CONNECTION'] . ' ' .
                'WHERE post_id=' . $postId
            );
            // удаляем файл с изображением
            unlink(FW_UPLOAD . '/' . $USER->getId() . '/' . $filename);
        }
    }

    private function isPostAuthor(string $postId, string $userId)
    {
        global $DB;

        /*
        SELECT * FROM posts
            LEFT JOIN users_posts ON posts.id=users_posts.post_id
                WHERE posts.id=1 AND users_posts.user_id=1;
        */
        $result = $DB->execute(
            'SELECT ' .
            $this->params['TABLE'] . '.image ' .
            'FROM ' . $this->params['TABLE'] . ' ' .
            'LEFT JOIN ' . $this->params['TABLE_CONNECTION'] . ' ' .
            'ON ' . $this->params['TABLE'] . '.id=' . $this->params['TABLE_CONNECTION'] . '.post_id ' . ' ' .
            'WHERE ' . $this->params['TABLE'] . '.id=' . $postId . ' AND ' . $this->params['TABLE_CONNECTION'] . '.user_id=' . $userId
        );

        if (!empty($result)) {
            return ($result['image']);
        } else {
            return (false);
        }
    }
}