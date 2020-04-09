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
        $component = str_replace(':', '\\', $component);
        return ('Framework\Components\\' . $component);
    }

    /**
     * Получение полного неймспейса компоненты
     * @param string $controller
     * @return string
     */
    public static function getControllerNamespace(string $controller)
    {
        return ('Framework\Controllers\\' . $controller);
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