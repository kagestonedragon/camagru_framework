<?php

namespace Framework\Modules;

use Framework\Helpers\Localization as LocHelper;

/**
 * Class Localization
 * @package Framework\Modules
 */
class Localization
{
    private static string $langFile;
    private static array $langMessages;

    /**
     * Ицициализация файла локализации
     * @param string $filename
     */
    public static function init(string $filename)
    {
        self::$langFile = LocHelper::getLangFilePath($filename);
        self::$langMessages = LocHelper::getLangMessages(self::$langFile);
    }

    /**
     * Метод получения сообщения из файла локализации
     * @param string $messageKey
     * @return mixed|string
     */
    public static function getMessage(string $messageKey)
    {
        if (isset(self::$langMessages[$messageKey])) {
            return (self::$langMessages[$messageKey]);
        } else {
            return ('');
        }
    }
}