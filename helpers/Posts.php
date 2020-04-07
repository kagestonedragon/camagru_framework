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
}