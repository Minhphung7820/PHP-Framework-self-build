<?php

namespace Core;

use PDO;
use PDOException;
use Supports\Facades\Logger;;

class ConnectDB
{
    private static $connection;

    public static function getConnection()
    {
        if (!isset(static::$connection)) {
            static::createConnection();
        }

        return static::$connection;
    }

    public static function createConnection()
    {
        $host = config('database.db_host');
        $username = config('database.db_user');
        $password = config('database.db_password');
        $database = config('database.db_name');
        try {
            static::$connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            Logger::error($e->getMessage());
        }
    }

    public static function beginTransaction()
    {
        return static::getConnection()->beginTransaction();
    }

    public static function commit()
    {
        return static::getConnection()->commit();
    }

    public static function rollback()
    {
        return static::getConnection()->rollBack();
    }

    public static function execute($sql, $values = [])
    {
        $stmt = static::getConnection()->prepare($sql);
        return $stmt->execute($values);
    }

    public static function executeInsertId($sql, $values = [])
    {
        $stmt = static::getConnection()->prepare($sql);
        $stmt->execute($values);
        return static::getConnection()->lastInsertId();
    }

    public static function executeQuery($sql, $values = [])
    {
        $stmt = static::getConnection()->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function executeSingle($sql, $values = [])
    {
        $stmt = static::getConnection()->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
