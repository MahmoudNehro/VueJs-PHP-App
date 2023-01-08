<?php

namespace Database;

class MySQLConnection extends BaseConnection
{

    private static $instances = [];

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): MySQLConnection
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function createConnection($host, $data_base, $user_name, $password)
    {
        $this->setHost($host);
        $this->setDataBase($data_base);
        $this->setUserName($user_name);
        $this->setPassword($password);
        $this->setConnection("mysql:host={$this->getHost()};dbname={$this->getDataBase()}", $this->getUserName(), $this->getPassword());
    }
}
