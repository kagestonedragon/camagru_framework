<?php

namespace Framework\Helpers;

use Framework\Modules\Debugger;

class Posts
{
    const ALLOWED_FILETYPES = [
        'jpg' => 'image/jpeg',
    ];

    public static function uploadFile(array $data, string $userId)
    {
        if (!empty($data) && Posts::validateFile($data['type'])) {
            $filename = hash(
                'md5',
                $data['name'] . rand()
            );
            $filename .= '.' . Posts::getExtByType($data['type']);
            $dest = FW_UPLOAD . '/' . $userId . '/' . $filename;
            if (!file_exists(FW_UPLOAD . '/' . $userId)) {
                mkdir(FW_UPLOAD . '/' . $userId);
            }
            copy($data['tmp_name'], $dest);

            return ($filename);
        } else {
            return (false);
        }
    }

    public static function validateFile(string $type)
    {
        if (array_search($type, Posts::ALLOWED_FILETYPES) !== false) {
            return (true);
        } else {
            return (false);
        }
    }

    public static function getExtByType(string $type)
    {
        return (array_keys(Posts::ALLOWED_FILETYPES, $type)[0]);
    }
}