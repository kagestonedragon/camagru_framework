<?php

namespace Framework\Modules;

use Framework\Helpers\Application as AppHelper;

class Application
{
    /**
     * Подключение компонента на странице
     * @noinspection PhpUndefinedMethodInspection
     * @param string $component
     * @param string $template
     * @param array $params
     */
    public function useComponent(string $component, string $template = 'default', array $params = array())
    {
        $componentNamespace = AppHelper::getComponentNamespace($component);
        $objectComponent = new $componentNamespace($params);

        $this->useTemplate($component, $template, $objectComponent->getResult());
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

    public function Redirect(string $url)
    {
        header('Location: ' . $url);
    }
}