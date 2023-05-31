<?php

namespace Core;

use Core\ConnectDB;

class Eloquent extends ConnectDB
{
    protected static $table;
    protected static $whereConditions = [];
    protected static $orWhereConditions = [];

    public function __construct($table)
    {
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

    public static function all()
    {
        $sql = "SELECT * FROM " . static::$table;
        return static::executeQuery($sql);
    }

    public static function get()
    {
        $values = [];
        $sql = "SELECT * FROM " . static::$table;

        $whereClause = static::buildWhereConditions();

        $sql .= $whereClause['sql'];
        $values = $whereClause['values'];

        return static::executeQuery($sql, $values);
    }

    public static function first()
    {
        $values = [];
        $sql = "SELECT * FROM " . static::$table;

        $whereClause = static::buildWhereConditions();

        $sql .= $whereClause['sql'];
        $values = $whereClause['values'];

        return static::executeSingle($sql, $values);
    }

    public static function update($data)
    {
        $sql = "UPDATE " . static::$table . " SET ";
        $setValues = [];

        foreach ($data as $column => $value) {
            $setValues[] = $column . " = ?";
        }

        $sql .= implode(", ", $setValues);

        $whereClause = static::buildWhereConditions();

        $sql .= $whereClause['sql'];
        $values = array_merge(array_values($data), $whereClause['values']);

        return static::execute($sql, $values);
    }

    public static function create($data = [])
    {
        $values = array_values($data);
        $mappings = [];
        $sql = "INSERT INTO " . static::$table . " (" . implode(",", array_keys($data)) . ") VALUES (";
        foreach (array_values($data) as $value) {
            $mappings[] = "?";
        }
        $sql .= implode(",", $mappings) . ") ";
        return static::executeInsertId($sql, $values);
    }

    public static function find($id)
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE id = ?";
        return static::executeSingle($sql, [$id]);
    }

    public static function delete()
    {
        $sql = "DELETE FROM " . static::$table;

        $whereClause = static::buildWhereConditions();

        $sql .= $whereClause['sql'];
        $values = $whereClause['values'];

        return static::execute($sql, $values);
    }

    protected static function buildWhereConditions()
    {
        $whereConditions = static::$whereConditions;
        $orWhereConditions = static::$orWhereConditions;
        $conditions = array_merge($whereConditions, $orWhereConditions);
        $whereSql = '';
        $whereValues = [];

        if (!empty($conditions)) {
            $whereSql .= " WHERE ";
            foreach ($conditions as $key => $condition) {
                $whereValues[] = $condition['value'];
                if ($key > 0) {
                    $whereSql .= ($key < count($whereConditions)) ? " AND " : " OR ";
                }
                $whereSql .= $condition['column'] . ' ' . $condition['operator'] . ' ?';
            }
        }

        return [
            'sql' => $whereSql,
            'values' => $whereValues
        ];
    }
}
