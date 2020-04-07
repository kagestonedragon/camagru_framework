<?php

namespace Framework\Modules;

/**
 * Class Request
 * @package Framework\Modules
 * Класс для обработки и парсинга запроса
 */
class Request
{
    private string $documentRoot;
    private string $uri;
    private string $method;

    public function __construct()
    {
        $this->uri = $this->parseUri($_SERVER['REQUEST_URI']);
        $this->method = $this->parseMethod($_SERVER['REQUEST_METHOD']);
        $this->method = $this->parseDocumentRoot($_SERVER['DOCUMENT_ROOT']);
    }

    /**
     * Позже здесь будет логика
     * @param string $uri
     * @return string
     */
    private function parseUri(string $uri)
    {
        return ($uri);
    }

    /**
     * Позже здесь будет логика
     * @param string $method
     * @return string
     */
    private function parseMethod(string $method)
    {
        return ($method);
    }

    /**
     * Позже тут будет логика
     * @param string $documentRoot
     * @return string
     */
    private function parseDocumentRoot(string $documentRoot)
    {
        return ($documentRoot);
    }

    /**
     * Позже здесь будет логика
     * @return string
     */
    public function getUri()
    {
        return ($this->uri);
    }

    /**
     * Позже здесь будет логика
     * @return string
     */
    public function getMethod()
    {
        return ($this->method);
    }

    public function getDocumentRoot()
    {
        return ($this->documentRoot);
    }

}