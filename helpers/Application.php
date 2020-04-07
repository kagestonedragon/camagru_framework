<?php

namespace Framework\Helpers;

class Application
{
    /**
     * Получение полного неймспейса компоненты
     * @param string $component
     * @return string
     */
    public static function getComponentNamespace(string $component)
    {
        return ('Framework\Components\\' . $component);
    }

    /**
     * Получение полного пути до шаблона
     * @param string $component
     * @param string $template
     * @return string
     */
    public static function getTemplatePath(string $component, string $template)
    {
        return (
            implode(
                '/',
                [
                    $_SERVER['DOCUMENT_ROOT'],
                    FW_NAME,
                    'templates',
                    $component,
                    $template,
                    'template.php',
                ]
            )
        );
    }
}