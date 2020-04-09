<?php

namespace Framework\Components\Basic;

class Component
{
    protected array $result = [];
    protected array $params = [];

    public function __construct(array $params)
    {
        $this->prepareParams($params);
        $this->Process();
    }

    protected function prepareParams(array $params)
    {
        $this->params = $params;
        // your logic
    }

    protected function Process()
    {
        // your logic
    }

    public function getResult()
    {
        return ($this->result);
    }
}