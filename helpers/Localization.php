<?php

namespace Framework\Helpers;

class Localization
{
    /**
     * Получение пути до файла с сообщениями
     * @param string $filename
     * @return string|string[]
     */
    public static function getLangFilePath(string $filename)
    {
        return (
            str_replace(
                FW_NAME,
                FW_NAME . '/languages/' . FW_LANG,
                $filename
            )
        );
    }

    /**
     * Получение списка сообщений из файла
     * @noinspection PhpIncludeInspection
     * @param string $langFile
     * @return array
     */
    public static function getLangMessages(string $langFile)
    {
        $message = [];
        include($langFile);

        return ($message);
    }

}