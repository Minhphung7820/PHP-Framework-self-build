<?php

namespace Core;

use Exception;
use PDO;
use Supports\Facades\Logger;;

class ConnectDB
{
    private $connection;

    public function __construct()
    {
        $host = config('database.db_host');
        $username = config('database.db_user');
        $password = config('database.db_password');
        $database = config('database.db_name');
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            Logger::error($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    public function commit()
    {
        return $this->connection->commit();
    }

    public function rollback()
    {
        return $this->connection->rollBack();
    }
}
