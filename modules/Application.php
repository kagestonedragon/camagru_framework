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
     * @param string $component
     * @param string $template
     * @param array $params
     */
    public function useComponent(string $component, string $template = 'default', array $params = [])
    {
        $componentNamespace = AppHelper::getComponentNamespace($component);
        $objectComponent = new $componentNamespace($params);

        $this->useTemplate(explode(':', $component)[0], $template, $objectComponent->getResult());
    }

    /**
     * Подключение шаблона (часть подключения компонента)
     * @noinspection PhpIncludeInspection
     * @param string $component
     * @param string $template
     * @param array $result
     */
    private function useTemplate(string $component, string $template, array $result)
    {
        require_once(
            AppHelper::getTemplatePath($component, $template)
        );
    }

    public function enableController(string $controller, array $params = [])
    {
        $controllerNamespace = AppHelper::getControllerNamespace($controller);
        $objectController = new $controllerNamespace($params);
    }

    public function Redirect(string $url)
    {
        header('Location: ' . $url);
    }
}