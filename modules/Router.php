<?php

namespace Framework\Modules;

class Router
{
    private array $config = [];
    public string $location = '';

    public function __construct(array $config, string $requestUri)
    {
        $this->config = $config;
        $this->prepare($requestUri);

    }

    private function prepare(string $requestUri)
    {
        foreach ($this->config as $item) {
            if (preg_match($item['PATTERN'], $requestUri, $matches)) {
                $this->setParams($item['PARAMS'], $matches);
                $this->location = $_SERVER['DOCUMENT_ROOT']  . $item['LOCATION'];
            }
        }
    }

    private function setParams(array $params, array $matches)
    {
        global $REQUEST;

        foreach ($params as $key => $value) {
            if (isset($matches[$value])) {
                $REQUEST->arGet[$key] = $matches[$value];
            } else {
                $REQUEST->arGet[$key] = $value;
            }
        }
    }
}