<?php

namespace Framework\Modules;

/**
 * Class Logger
 * @package Framework\Modules
 */
class Logger
{
    /**
     * Запись лога в файл
     * @param string $file
     * @param string $text
     */
    public static function write(string $file, string $text)
    {
        file_put_contents(Logger::formatFilePath($file), Logger::formatLogRecord($text), FILE_APPEND);
    }

    /**
     * Формирование текста лога
     * @param string $text
     * @return string
     */
    private static function formatLogRecord(string $text)
    {
        return (
            date('d-m-Y h:i:sa') . ' | ' . $text . PHP_EOL
        );
    }

    /**
     * Формирование полного пути до файла с логами
     * @param string $file
     * @return string
     */
    private static function formatFilePath(string $file)
    {
        return (
            FW_LOGS . '/' . $file
        );
    }
}