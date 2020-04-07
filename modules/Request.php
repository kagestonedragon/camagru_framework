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
    public array $arGet = [];
    public array $arPost = [];
    public array $arFiles = [];

    public function __construct()
    {
        $this->uri = $this->parseUri($_SERVER['REQUEST_URI']);
        $this->method = $this->parseMethod($_SERVER['REQUEST_METHOD']);
        $this->documentRoot = $this->parseDocumentRoot($_SERVER['DOCUMENT_ROOT']);

        if ($this->method == 'GET') {
            $this->arGet = $this->parseData($_GET);
        } else if ($this->method == 'POST') {
            $this->arPost = $this->parseData($_POST);
        }

        if (!empty($_FILES)) {
            $this->arFiles = $this->parseData($_FILES);
        }
    }

    /**
     * Позже здесь будет логика
     * @param string $uri
     * @return array
     */
    private function parseData(array $data)
    {
        return ($data);
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

    /**
     * Позже здесь будет логика
     * @return string
     */
    public function getDocumentRoot()
    {
        return ($this->documentRoot);
    }

}