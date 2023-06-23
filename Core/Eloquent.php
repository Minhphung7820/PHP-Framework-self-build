<?php

namespace Core;

use Core\ConnectDB;

/**
 * Lớp thực thi truy vấn dữ liệu từ Database.
 * 
 * Lớp `Eloquent` đại diện cho một model trong kiểu framework.
 * Nó cung cấp các phương thức để xây dựng và thực thi các câu truy vấn SQL.
 * 
 * @author	Truong Minh Phung Back-End PHP Developer
 * @package Core
 */
class Eloquent extends ConnectDB
{
    /**
     * Bảng tương ứng với model.
     *
     * @var string
     */
    protected static $table;

    /**
     * Các điều kiện WHERE cho câu truy vấn.
     *
     * @var array
     */
    protected static $whereConditions = [];

    /**
     * Các điều kiện OR WHERE cho câu truy vấn.
     *
     * @var array
     */
    protected static $orWhereConditions = [];

    /**
     * Các điều kiện JOIN cho câu truy vấn.
     *
     * @var array
     */
    protected static $joinClauses = [];

    /**
     * Các cột được nhóm theo GROUP BY cho câu truy vấn.
     *
     * @var array
     */
    protected static $groupByColumns = [];

    /**
     * Các điều kiện HAVING cho câu truy vấn.
     *
     * @var array
     */
    protected static $havingConditions = [];

    /**
     * Các cột được sắp xếp theo ORDER BY cho câu truy vấn.
     *
     * @var array
     */
    protected static $orderByColumns = [];

    /**
     * Các cột được chọn trong câu truy vấn SELECT.
     *
     * @var array
     */
    protected static $selectColumns = [];


    /**
     * Khởi tạo một instance của lớp Eloquent.
     *
     * @param string $table Bảng tương ứng với model
     */
    public function __construct($table)
    {
        static::$table = $table;
    }


    /**
     * Thiết lập điều kiện WHERE cho câu truy vấn.
     *
     * @param string $column    Tên cột
     * @param string $operator  Toán tử so sánh
     * @param mixed  $value     Giá trị so sánh
     *
     * @return Eloquent
     */
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


    /**
     * Thiết lập điều kiện WHERE cho việc đăng nhập.
     *
     * @param array $conditions Mảng các điều kiện
     *
     * @return Eloquent
     */
    public static function whereAttempLogin(array $conditions)
    {
        foreach ($conditions as $key => $value) {
            static::$whereConditions[] = [
                'column' =>  $key,
                'operator' => "=",
                'value' => $value
            ];
        }
        $className = get_called_class();
        return new $className(static::$table);
    }

    /**
     * Thiết lập điều kiện OR WHERE cho câu truy vấn.
     *
     * @param string $column    Tên cột
     * @param string $operator  Toán tử so sánh
     * @param mixed  $value     Giá trị so sánh
     *
     * @return Eloquent
     */
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

    /**
     * Thực hiện JOIN với một bảng.
     *
     * @param string $table         Tên bảng tham gia JOIN
     * @param string $firstColumn   Tên cột trong bảng gốc
     * @param string $operator      Toán tử so sánh
     * @param string $secondColumn  Tên cột trong bảng tham gia JOIN
     *
     * @return Eloquent
     */
    public static function join($table, $firstColumn, $operator, $secondColumn)
    {
        static::$joinClauses[] = [
            'type' => 'INNER',
            'table' => $table,
            'firstColumn' => $firstColumn,
            'operator' => $operator,
            'secondColumn' => $secondColumn
        ];
        $className = get_called_class();
        return new $className(static::$table);
    }

    /**
     * Thực hiện LEFT JOIN với một bảng.
     *
     * @param string $table         Tên bảng tham gia LEFT JOIN
     * @param string $firstColumn   Tên cột trong bảng gốc
     * @param string $operator      Toán tử so sánh
     * @param string $secondColumn  Tên cột trong bảng tham gia LEFT JOIN
     *
     * @return Eloquent
     */
    public static function leftJoin($table, $firstColumn, $operator, $secondColumn)
    {
        static::$joinClauses[] = [
            'type' => 'LEFT',
            'table' => $table,
            'firstColumn' => $firstColumn,
            'operator' => $operator,
            'secondColumn' => $secondColumn
        ];
        $className = get_called_class();
        return new $className(static::$table);
    }

    /**
     * Thực hiện RIGHT JOIN với một bảng.
     *
     * @param string $table         Tên bảng tham gia RIGHT JOIN
     * @param string $firstColumn   Tên cột trong bảng gốc
     * @param string $operator      Toán tử so sánh
     * @param string $secondColumn  Tên cột trong bảng tham gia RIGHT JOIN
     *
     * @return Eloquent
     */
    public static function rightJoin($table, $firstColumn, $operator, $secondColumn)
    {
        static::$joinClauses[] = [
            'type' => 'RIGHT',
            'table' => $table,
            'firstColumn' => $firstColumn,
            'operator' => $operator,
            'secondColumn' => $secondColumn
        ];
        $className = get_called_class();
        return new $className(static::$table);
    }

    /**
     * Thiết lập điều kiện HAVING cho câu truy vấn.
     *
     * @param string $column    Tên cột trong bảng
     * @param string $operator  Toán tử so sánh
     * @param mixed  $value     Giá trị so sánh
     *
     * @return Eloquent
     */
    public static function having($column, $operator, $value)
    {
        static::$havingConditions[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        $className = get_called_class();
        return new $className(static::$table);
    }

    /**
     * Thiết lập nhóm các cột theo một cột.
     *
     * @param string $column  Tên cột trong bảng
     *
     * @return Eloquent
     */
    public static function groupBy($column)
    {
        static::$groupByColumns[] = $column;
        $className = get_called_class();
        return new $className(static::$table);
    }

    /**
     * Thiết lập thứ tự sắp xếp các kết quả truy vấn.
     *
     * @param string $column     Tên cột trong bảng
     * @param string $direction  Hướng sắp xếp (ASC hoặc DESC)
     *
     * @return Eloquent
     */
    public static function orderBy($column, $direction = 'ASC')
    {
        static::$orderByColumns[] = [
            'column' => $column,
            'direction' => $direction
        ];
        $className = get_called_class();
        return new $className(static::$table);
    }

    /**
     * Thiết lập các cột được lựa chọn trong câu truy vấn SELECT.
     *
     * @param mixed $columns  Tên các cột hoặc các đối số đại diện cho các cột
     *
     * @return Eloquent
     */
    public static function select($columns)
    {
        if (!is_array($columns)) {
            $columns = func_get_args();
        }
        static::$selectColumns = $columns;
        $className = get_called_class();
        return new $className(static::$table);
    }

    /**
     * Trả về tất cả các bản ghi trong bảng.
     *
     * @return array
     */
    public static function all()
    {
        $sql = "SELECT * FROM " . static::$table;
        return static::executeQuery($sql);
    }

    /**
     * Trả về các bản ghi truy vấn dựa trên các điều kiện đã thiết lập.
     *
     * @return array
     */
    public static function get()
    {
        $values = [];
        $sql = "SELECT * FROM " . static::$table;

        $whereClause = static::buildWhereConditions();

        $sql .= $whereClause['sql'];
        $values = $whereClause['values'];

        if (!empty(static::$joinClauses)) {
            foreach (static::$joinClauses as $joinClause) {
                $sql .= $joinClause['type'] . " JOIN " . $joinClause['table'] . " ON " . $joinClause['firstColumn'] . " " . $joinClause['operator'] . " " . $joinClause['secondColumn'];
            }
        }

        if (!empty(static::$groupByColumns)) {
            $sql .= " GROUP BY " . implode(", ", static::$groupByColumns);
        }

        if (!empty(static::$havingConditions)) {
            $sql .= " HAVING ";
            foreach (static::$havingConditions as $key => $condition) {
                $values[] = $condition['value'];
                if ($key > 0) {
                    $sql .= ($key < count(static::$havingConditions)) ? " AND " : " OR ";
                }
                $sql .= $condition['column'] . ' ' . $condition['operator'] . ' ?';
            }
        }

        if (!empty(static::$orderByColumns)) {
            $sql .= " ORDER BY ";
            foreach (static::$orderByColumns as $key => $orderByColumn) {
                $sql .= $orderByColumn['column'] . ' ' . $orderByColumn['direction'];
                if ($key < count(static::$orderByColumns) - 1) {
                    $sql .= ", ";
                }
            }
        }

        return static::executeQuery($sql, $values);
    }

    /**
     * Trả về một bản ghi đầu tiên của truy vấn.
     *
     * @return mixed
     */
    public static function first()
    {
        $values = [];
        $sql = "SELECT * FROM " . static::$table;

        $whereClause = static::buildWhereConditions();

        $sql .= $whereClause['sql'];
        $values = $whereClause['values'];

        if (!empty(static::$joinClauses)) {
            foreach (static::$joinClauses as $joinClause) {
                $sql .= $joinClause['type'] . " JOIN " . $joinClause['table'] . " ON " . $joinClause['firstColumn'] . " " . $joinClause['operator'] . " " . $joinClause['secondColumn'];
            }
        }

        if (!empty(static::$groupByColumns)) {
            $sql .= " GROUP BY " . implode(", ", static::$groupByColumns);
        }

        if (!empty(static::$havingConditions)) {
            $sql .= " HAVING ";
            foreach (static::$havingConditions as $key => $condition) {
                $values[] = $condition['value'];
                if ($key > 0) {
                    $sql .= ($key < count(static::$havingConditions)) ? " AND " : " OR ";
                }
                $sql .= $condition['column'] . ' ' . $condition['operator'] . ' ?';
            }
        }

        if (!empty(static::$orderByColumns)) {
            $sql .= " ORDER BY ";
            foreach (static::$orderByColumns as $key => $orderByColumn) {
                $sql .= $orderByColumn['column'] . ' ' . $orderByColumn['direction'];
                if ($key < count(static::$orderByColumns) - 1) {
                    $sql .= ", ";
                }
            }
        }

        return static::executeSingle($sql, $values);
    }

    /**
     * Thực hiện câu truy vấn UPDATE và trả về số bản ghi bị ảnh hưởng.
     *
     * @param array $data  Dữ liệu cần cập nhật
     *
     * @return int
     */
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

    /**
     * Thực hiện câu truy vấn INSERT và trả về ID của bản ghi vừa được tạo.
     *
     * @param array $data  Dữ liệu của bản ghi
     *
     * @return int
     */
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

    /**
     * Trả về chi tiết một bảng ghi.
     *
     * @return array
     */
    public static function find($id)
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE id = ?";
        return static::executeSingle($sql, [$id]);
    }

    /**
     * Thực hiện câu truy vấn DELETE và trả về số bản ghi bị xóa.
     *
     * @return int
     */
    public static function delete()
    {
        $sql = "DELETE FROM " . static::$table;

        $whereClause = static::buildWhereConditions();

        $sql .= $whereClause['sql'];
        $values = $whereClause['values'];

        return static::execute($sql, $values);
    }

    /**
     * Xây dựng điều kiện WHERE dựa trên các điều kiện đã thiết lập.
     *
     * @return array
     */
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
