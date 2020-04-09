<?php

namespace Framework\Helpers;

use Framework\Modules\Debugger;

class Application
{
    /**
     * @example Framework\Models\Posts\GetList
     * Получение полного неймспейса компоненты
     * @param string $model
     * @return string
     */
    public static function getModelNamespace(string $model)
    {
        $model = str_replace('::', '\\', $model);

        return ('Framework\Models\\' . $model);
    }

    /**
     * @example Framework\Controllers\Posts
     * Получение полного неймспейса компоненты
     * @param string $controller
     * @return string
     */
    public static function getControllerNamespace(string $controller)
    {
        return ('Framework\Controllers\\' . $controller);
    }


    /**
     * @example /.../framework/view/Posts/list/view.php
     * Получение полного пути до шаблона
     * @param string $view
     * @return string
     */
    public static function getViewPath(string $view)
    {
        $view = explode('.', $view);

        return (
            implode(
                '/',
                [
                    $_SERVER['DOCUMENT_ROOT'],
                    FW_NAME,
                    'view',
                    $view[0],
                    $view[1],
                    'view.php',
                ]
            )
        );
    }
}