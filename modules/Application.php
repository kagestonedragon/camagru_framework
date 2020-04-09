<?php

namespace Framework\Modules;

use Framework\Helpers\Application as AppHelper;

/**
 * Class Application
 * @package Framework\Modules
 * 1. Вынести редирект в отдельный модуль ($request)
 */
class Application
{
    /**
     * Подключение компонента на странице
     * @noinspection PhpUndefinedMethodInspection
     * @param string $model
     * @param array $params
     * @return array
     */
    public function loadModel(string $model, array $params = [])
    {
        $modelNamespace = AppHelper::getModelNamespace($model);

        return (
            (new $modelNamespace($params))->getResult()
        );
    }

    /**
     * Подключение view (шаблона)
     * @noinspection PhpIncludeInspection
     * @param string $view
     * @param array $result
     */
    public function loadView(string $view, array $result = [])
    {
        require_once(AppHelper::getViewPath($view));
    }

    public function loadController(string $controller, array $params = [])
    {
        $controllerNamespace = AppHelper::getControllerNamespace($controller);
        new $controllerNamespace($params);
    }

    public function Redirect(string $url)
    {
        header('Location: ' . $url);
    }
}