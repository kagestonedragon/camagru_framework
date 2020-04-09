<?php

namespace Framework\Models\Basic;

class Model
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

    protected function process()
    {
        // your logic
    }

    public function getResult()
    {
        return ($this->result);
    }

    protected function setStatus(string $status)
    {
        $this->result['status'] = $status;
    }
}