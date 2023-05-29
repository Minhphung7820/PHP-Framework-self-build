<?php

namespace Core;

use Core\ConnectDB;
use Supports\Facades\LogFacade;
use PDO;

class Eloquent extends ConnectDB
{
    protected static $table;
    protected static $whereConditions = [];
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

    public function get()
    {
        $values = [];
        $sql = "SELECT * FROM " . static::$table;

        if (!empty(static::$whereConditions)) {
            $sql .= " WHERE ";
            foreach (static::$whereConditions as $key => $condition) {
                $values[] = $condition['value'];
                if ($key > 0) {
                    $sql .= " AND ";
                }
                $sql .= $condition['column'] . ' ' . $condition['operator'] . ' ' . "?";
            }
        }
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(array_values($values));
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
