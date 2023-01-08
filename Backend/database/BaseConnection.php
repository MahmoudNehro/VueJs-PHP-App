<?php

namespace Database;

use PDO;
use PDOException;

abstract class BaseConnection
{
    private string $host;
    private string $data_base;
    private string $user_name;
    private string $password;
    private ?PDO $connection = null;
    /**
     * @param string $data_base
     */
    protected function setDataBase(string $data_base): void
    {
        $this->data_base = $data_base;
    }

    /**
     * @param string $user_name
     */
    protected function setUserName(string $user_name): void
    {
        $this->user_name = $user_name;
    }

    /**
     * @param string $host
     */
    protected function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @param string $password
     */
    protected function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param $credentials
     * @param $user_name
     * @param $password
     * @return void
     */
    protected function setConnection($credentials, $userName, $userPassword): void
    {
        $this->connection = null;
        try {
            $this->connection = new PDO($credentials, $userName, $userPassword);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
    }
    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
    /**
     * @return string
     */
    protected function getDataBase(): string
    {
        return $this->data_base;
    }
    /**
     * @return string
     */
    protected function getUserName(): string
    {
        return $this->user_name;
    }

    /**
     * @return string
     */
    protected function getHost(): string
    {
        return $this->host;
    }
    /**
     * @return string
     */
    protected function getPassword(): string
    {
        return $this->password;
    }
}
