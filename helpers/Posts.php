<?php

namespace Framework\Helpers;

use Framework\Modules\Debugger;

class Posts
{
    public static function generatePathToImages(array &$items, string $dir)
    {
        foreach ($items as $itemKey => $itemValue) {
            $items[$itemKey]['image'] = $dir . $itemValue['user_id'] . '/' . $itemValue['image'];
        }

        return ($items);
    }

    public static function sortCommentariesByPostId(array $items, array $keys)
    {
        $sortedItems = Posts::getEmptyArray($keys);

        foreach ($items as $itemKey => $itemValue) {
            $sortedItems[$itemValue['post_id']][] = $itemValue;
        }

        return ($sortedItems);
    }

    public static function sortLikesByPostId(array $items, array $keys)
    {
        $sortedItems = Posts::getEmptyArray($keys);

        foreach ($items as $itemKey => $itemValue) {
            $sortedItems[$itemValue['post_id']][] = $itemValue['user_id'];
        }

        return ($sortedItems);
    }

    public static function setLikeActions(array &$items, array $likes, string $userId)
    {
        foreach ($items as $key => $value) {
            $items[$key]['LIKE_ACTION'] = 'add';
            if (isset($likes[$value['id']]) && in_array($userId, $likes[$value['id']])) {
                $items[$key]['LIKE_ACTION'] = 'delete';
            }
        }
    }

    private static function getEmptyArray(array $keys)
    {
        $result = [];

        foreach ($keys as $item) {
            $result[$item] = [];
        }

        return ($result);
    }
}