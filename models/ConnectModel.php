<?php

class ConnectModel
{
    protected $pdo;
    protected static $instance = null;

    // Sử dụng Singleton pattern để đảm bảo chỉ có một kết nối đến cơ sở dữ liệu
    private function __construct()
    {
        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);

        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
        } catch (PDOException $e) {
            // Xử lý lỗi kết nối
            die("Kết nối cơ sở dữ liệu thất bại: {$e->getMessage()}. Vui lòng thử lại sau.");
        }
    }

    // Phương thức để lấy instance của ConnectModel
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new ConnectModel();
        }

        return self::$instance;
    }

    // Lấy đối tượng PDO để thực hiện các truy vấn
    public function getConnection()
    {
        return $this->pdo;
    }

    // Thực hiện truy vấn SELECT và trả về tất cả kết quả
    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Thực hiện truy vấn SELECT và trả về một kết quả
    public function queryOne($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    // Thực hiện truy vấn INSERT, UPDATE, DELETE
    public function execute($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // Lấy ID của bản ghi vừa được thêm vào
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    // Bắt đầu một transaction
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    // Commit một transaction
    public function commit()
    {
        return $this->pdo->commit();
    }

    // Rollback một transaction
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    // Ngăn chặn việc clone đối tượng
    private function __clone() {}

    // Ngăn chặn việc unserialize đối tượng
    private function __wakeup() {}
}