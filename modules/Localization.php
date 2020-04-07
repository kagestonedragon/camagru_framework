<?php

namespace Framework\Modules;

use Framework\Helpers\Localization as LocHelper;

class Localization
{
    private static string $langFile;
    private static array $langMessages;

    public static function init(string $filename)
    {
        self::$langFile = LocHelper::getLangFilePath($filename);
        self::$langMessages = LocHelper::getLangMessages(self::$langFile);
    }

    public static function getMessage(string $messageKey)
    {
        if (isset(self::$langMessages[$messageKey])) {
            return (self::$langMessages[$messageKey]);
        } else {
            return ('');
        }
    }
}