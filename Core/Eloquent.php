<?php

namespace Core;

use Core\ConnectDB;
use PDO;

class Eloquent extends ConnectDB
{
    protected static $table;
    protected static $whereConditions = [];
    protected static $orWhereConditions = [];

    public function __construct($table)
    {
        parent::__construct();
        static::$table = $table;
    }

    public static function where($column, $operator, $value)
    {
        static::$whereConditions[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        $className = get_called_class();
        return new $className(static::$table);
    }

    public static function orWhere($column, $operator, $value)
    {
        static::$orWhereConditions[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        $className = get_called_class();
        return new $className(static::$table);
    }

    public function get()
    {
        $values = [];
        $sql = "SELECT * FROM " . static::$table;

        if (!empty(static::$whereConditions) || !empty(static::$orWhereConditions)) {
            $sql .= " WHERE ";
            $whereConditions = static::$whereConditions;
            $orWhereConditions = static::$orWhereConditions;
            $conditions = array_merge($whereConditions, $orWhereConditions);

            foreach ($conditions as $key => $condition) {
                $values[] = $condition['value'];
                if ($key > 0) {
                    $sql .= ($key < count($whereConditions)) ? " AND " : " OR ";
                }
                $sql .= $condition['column'] . ' ' . $condition['operator'] . ' ' . "?";
            }
        }

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(array_values($values));
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
