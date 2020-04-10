<?php

namespace Framework\Helpers;

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

    private static function getEmptyArray(array $keys)
    {
        $result = [];

        foreach ($keys as $item) {
            $result[$item] = [];
        }

        return ($result);
    }
}