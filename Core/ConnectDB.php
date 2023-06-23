<?php

namespace Core;

use PDO;
use PDOException;
use Supports\Facades\Logger;;

/**
 * Lớp quản lý kết nối cơ sở dữ liệu.
 *
 * Lớp `ConnectDB` cung cấp các phương thức để quản lý kết nối và thực hiện các thao tác trên cơ sở dữ liệu.
 * Sử dụng đối tượng PDO để tạo kết nối và thực hiện truy vấn SQL.
 * 
 * @author	Truong Minh Phung Back-End PHP Developer <minhphung485@gmail.com>
 * @package Core
 */
class ConnectDB
{
    /**
     * Đối tượng kết nối cơ sở dữ liệu.
     *
     * Đây là một thuộc tính tĩnh của lớp `ConnectDB` dùng để lưu trữ đối tượng kết nối đến cơ sở dữ liệu.
     * Khi lớp `ConnectDB` được sử dụng để tạo kết nối, đối tượng PDO sẽ được tạo và gán cho thuộc tính này.
     * Thuộc tính này là `private`, chỉ có thể truy cập từ bên trong lớp `ConnectDB`.
     *
     * @var PDO
     */
    private static $connection;

    /**
     * Phương thức để lấy kết nối đến cơ sở dữ liệu.
     *
     * @return PDO Đối tượng PDO đại diện cho kết nối đến cơ sở dữ liệu.
     */
    public static function getConnection()
    {
        if (!isset(static::$connection)) {
            static::createConnection();
        }

        return static::$connection;
    }

    /**
     * Phương thức để tạo kết nối đến cơ sở dữ liệu.
     *
     * @return void
     */
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
            throw new \Exception("Failed to connect to the database.", 500);
        }
    }

    /**
     * Phương thức để bắt đầu một giao dịch trong cơ sở dữ liệu.
     *
     * @return bool Trả về true nếu thành công, ngược lại trả về false.
     */
    public static function beginTransaction()
    {
        return static::getConnection()->beginTransaction();
    }

    /**
     * Phương thức để xác nhận một giao dịch trong cơ sở dữ liệu.
     *
     * @return bool Trả về true nếu thành công, ngược lại trả về false.
     */
    public static function commit()
    {
        return static::getConnection()->commit();
    }

    /**
     * Phương thức để hủy bỏ một giao dịch trong cơ sở dữ liệu.
     *
     * @return bool Trả về true nếu thành công, ngược lại trả về false.
     */
    public static function rollback()
    {
        return static::getConnection()->rollBack();
    }

    /**
     * Phương thức để thực thi một câu lệnh SQL không trả về kết quả.
     *
     * @param string $sql Câu lệnh SQL.
     * @param array $values Các giá trị tham số cho câu lệnh SQL.
     * @return bool Trả về true nếu thành công, ngược lại trả về false.
     */
    public static function execute($sql, $values = [])
    {
        $stmt = static::getConnection()->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Phương thức để thực thi một câu lệnh SQL và trả về ID của bản ghi mới được chèn vào cơ sở dữ liệu.
     *
     * @param string $sql Câu lệnh SQL.
     * @param array $values Các giá trị tham số cho câu lệnh SQL.
     * @return string ID của bản ghi mới được chèn vào cơ sở dữ liệu.
     */
    public static function executeInsertId($sql, $values = [])
    {
        $stmt = static::getConnection()->prepare($sql);
        $stmt->execute($values);
        return static::getConnection()->lastInsertId();
    }

    /**
     * Phương thức để thực thi một câu lệnh SQL và trả về kết quả dưới dạng một mảng các đối tượng.
     *
     * @param string $sql Câu lệnh SQL.
     * @param array $values Các giá trị tham số cho câu lệnh SQL.
     * @return array Mảng các đối tượng đại diện cho kết quả truy vấn.
     */
    public static function executeQuery($sql, $values = [])
    {
        $stmt = static::getConnection()->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Phương thức để thực thi một câu lệnh SQL và trả về kết quả đầu tiên dưới dạng một đối tượng.
     *
     * @param string $sql Câu lệnh SQL.
     * @param array $values Các giá trị tham số cho câu lệnh SQL.
     * @return object|false Đối tượng đại diện cho kết quả đầu tiên của truy vấn, hoặc false nếu không có kết quả.
     */
    public static function executeSingle($sql, $values = [])
    {
        $stmt = static::getConnection()->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
