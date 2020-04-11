<?php

namespace Framework\Modules;

use \PDO as PDO;
use \PDOException as PDOException;

use Framework\Helpers\Database as DbHelper;
use Framework\Modules\Localization as Loc;

Loc::init(__FILE__);

/**
 * Class Database
 * @package Framework\Modules
 * Класс для работы в базой данных
 */
class Database
{
    const LOG_FILE = 'database.log';

    private array $config = [];
    private PDO $pdo;

    public function __construct(array $config)
    {
        $this->validateConfig($config);
        $this->config = $config;
        $this->pdo = $this->connect();
    }

    /**
     * Метод подключение к базе данных
     * @return PDO
     */
    public function connect()
    {
        try {
            $pdo = new PDO(
                DbHelper::getDestination($this->config['host'], $this->config['dbname']),
                $this->config['username'],
                $this->config['password'],
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return ($pdo);
        } catch (PDOException $e) {
            Logger::write(
                Database::LOG_FILE,
                Loc::getMessage('L_E_CONNECT') . ' ' . $e->getMessage()
            );
        }
    }

    /**
     * Метод валидации конфигурации
     * @param array $config
     */
    private function validateConfig(array $config)
    {
        if (
            empty($config) ||
            !isset($config['host']) || empty($config['host']) ||
            !isset($config['dbname']) || empty($config['dbname']) ||
            !isset($config['username']) || empty($config['username']) ||
            !isset($config['password']) || empty($config['password'])
        ) {
            Logger::write(
                Database::LOG_FILE,
                Loc::getMessage('L_E_CONFIG')
            );
        }
    }

    /**
     * Исполнение запроса
     * @param string $query
     * @param array $params
     * @param bool $isOne
     * @return array|mixed|string
     */
    public function execute(string $query, array $params = [], bool $isOne = true)
    {
        //Debugger::show($query, false);
        $pdoQuery = $this->pdo->prepare($query);
        $pdoQuery->execute($params);

        if (strpos($query, 'INSERT INTO') === false &&
            strpos($query, 'DELETE') === false &&
            strpos($query, 'UPDATE') === false
        ) {
            $result = $pdoQuery->fetchAll(PDO::FETCH_ASSOC);

            return ((count($result) == 1 && $isOne) ? $result[0] : $result);
        } else {
            return ('');
        }
    }

    /**
     * Получение id последнего добавленного элемента
     * @param string $table
     * @return mixed
     */
    public function getLastInsertedId(string $table)
    {
        return (
            $this->execute(
                'SELECT LAST_INSERT_ID() FROM ' . $table . ' limit  1'
            )['LAST_INSERT_ID()']
        );
    }
}