<?php

namespace Framework\Modules;
use Framework\Helpers\ORM as ORMHelper;
use Framework\Modules\Debugger;

/**
 * Class ORM
 * @package Framework\Modules
 * Класс, объекты которого упращают написание запросов в БД
 */
class ORM
{
    private string $query = '';
    private string $table = '';

    public function __construct(string $table)
    {
        $this->table = $table;

        return ($this);
    }

    public function select(array $fields)
    {
        $this->query .= 'SELECT ' . implode(', ', $fields);
        $this->query .= ' ';
        $this->from();

        return ($this);
    }

    public function insert(array $values)
    {
        $fields = implode(', ',  array_keys($values));
        $values = implode(', ', array_values($values));

        $this->query .= 'INSERT INTO';
        $this->query .= ' ';
        $this->query .= $this->table;
        $this->query .= ' ';
        $this->query .= '(' . $fields . ')';
        $this->query .= ' ';
        $this->query .= 'VALUES (' . $values . ')';
        $this->query .= ' ';

        return ($this);
    }

    public function update(array $values)
    {
        $this->query .= 'UPDATE ';
        $this->query .= $this->table;
        $this->query .= ' SET ';
        $this->query .= ORMHelper::getUpdateValues($values);
        $this->query .= ' ';

        return ($this);
    }

    public function delete()
    {
        $this->query .= 'DELETE';
        $this->query .= ' ';
        $this->from();

        return ($this);
    }

    public function where(string $condition)
    {
        $this->query .= 'WHERE ' . $condition;
        $this->query .= ' ';

        return ($this);
    }

    public function in(array $fields)
    {
        $this->query .= 'IN ';
        if (!empty($fields)) {
            $this->query .= '(' . implode(',', $fields) . ')';
        } else {
            $this->query .= '(0)';
        }
        $this->query .= ' ';

        return ($this);
    }

    public function and(string $condition)
    {
        $this->query .= 'AND ' . $condition;
        $this->query .= ' ';

        return ($this);
    }

    public function or(string $condition)
    {
        $this->query .= 'OR ' . $condition;
        $this->query .= ' ';

        return ($this);
    }

    public function left(string $table, string $on)
    {
        $this->query .= 'LEFT JOIN ' . $table;
        $this->query .= ' ON ';
        $this->query .= $on;
        $this->query .= ' ';

        return ($this);
    }

    private function from()
    {
        $this->query .= 'FROM ' . $this->table;
        $this->query .= ' ';

        return ($this);
    }

    public function order(string $table, string $direction)
    {
        $this->query .= 'ORDER BY ' . $table;
        $this->query .= ' ' . $direction;
        $this->query .= ' ';

        return ($this);
    }

    private function prepareQuery(array $params = [])
    {
        $this->table = $params[$this->table];

        foreach ($params as $key => $value) {
            if ($key[0] == '#') {
                $this->query = str_replace($key, $value, $this->query);
                unset($params[$key]);
            } else if ($key[0] == ':') {
                $value = "'" . $value ."'";
                $this->query = str_replace($key, $value, $this->query);
                unset($params[$key]);
            }
        }

        $this->query = trim($this->query);
        return ($this->query);
    }

    public function execute(array $params = [], bool $isOne = true)
    {
        global $DB;

        $result = $DB->execute(
            $this->prepareQuery($params),
            $params,
            $isOne
        );
        if (strpos($this->query, 'INSERT INTO') === false) {
            return ($result);
        } else {
            return (
                $DB->getLastInsertedId($this->table)
            );
        }
    }
}