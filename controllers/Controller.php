<?php

namespace Framework\Controllers;

class Controller
{
    public array $params = [];
    public function __construct(array $params)
    {
        $this->prepare($params);
        $this->Process();
    }

    protected function Process()
    {

    }

    protected function prepare(array $params)
    {
        $this->params = $params;
    }
}