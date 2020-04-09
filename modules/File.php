<?php

namespace Framework\Modules;

class File
{
    /**
     * Разрешенные расширения для загрузки
     */
    const ALLOWED_EXT = [
        'jpg' => 'image/jpeg',
    ];

    /**
     * Метод загрузки файла на сервер
     * @param string $dir
     * @param string $name
     * @param string $type
     * @param string $tmp
     * @return bool|string
     */
    public static function upload(string $dir, string $name, string $type = '', string $tmp = '')
    {
        $newName = false;

        if (File::validateType($type)) {
            $newName = hash('md5', $name . rand());
            $newName .= '.' . File::getExt($type);
            $dest = FW_UPLOAD_PATH . '/' . $dir;
            File::validateDir($dest);
            $path = $dest . '/' . $newName;
            copy($tmp, $path);
        }

        return ($newName);
    }

    /**
     * Метод удаления файла с сервера
     * @param string $dir
     * @param string $file
     */
    public static function delete(string $dir, string $file)
    {
        unlink(FW_UPLOAD_PATH . '/' . $dir . '/' . $file);
    }

    /**
     * Валидация пришедшего типа
     * @param string $type
     * @return false|int|string
     */
    private static function validateType(string $type)
    {
        return (
            array_search(
                $type,
                File::ALLOWED_EXT
            )
        );
    }

    /**
     * Метод проверки директории на существования
     * @param string $dir
     */
    private static function validateDir(string $dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir);
        }
    }

    /**
     * Метод получения расширения файла по его названию
     * @param string $type
     * @return mixed
     */
    private static function getExt(string $type)
    {
        return (
            array_keys(File::ALLOWED_EXT, $type)[0]
        );
    }
}