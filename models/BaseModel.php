<?php

class BaseModel
{
    protected $table;
    protected $pdo;
    
    // Getter cho thuộc tính pdo
    public function getPdo()
    {
        return $this->pdo;
    }

    // Kết nối CSDL
    public function __construct()
    {
        try {
            // Thử kết nối đến MySQL mà không chỉ định cơ sở dữ liệu
            $dsn = sprintf('mysql:host=%s;port=%s;charset=utf8', DB_HOST, DB_PORT);
            $tempPdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
            
            // Kiểm tra xem cơ sở dữ liệu đã tồn tại chưa
            $checkDb = $tempPdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . DB_NAME . "'");
            if ($checkDb->rowCount() == 0) {
                // Cơ sở dữ liệu chưa tồn tại, tạo mới
                echo '<script>console.log("Cơ sở dữ liệu ' . DB_NAME . ' chưa tồn tại, đang tạo mới...");</script>';
                $tempPdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                echo '<script>console.log("Đã tạo cơ sở dữ liệu ' . DB_NAME . '");</script>';
                
                // Tạo các bảng cần thiết
                $tempPdo->exec("USE " . DB_NAME);
                
                // Đọc và thực thi file SQL
                $sqlFile = PATH_ROOT . 'database/polyshop_schema.sql';
                if (file_exists($sqlFile)) {
                    $sql = file_get_contents($sqlFile);
                    
                    // Tách các câu lệnh SQL riêng biệt và thực thi từng câu
                    $queries = explode(';', $sql);
                    foreach ($queries as $query) {
                        $query = trim($query);
                        if (!empty($query)) {
                            try {
                                $tempPdo->exec($query);
                                echo '<script>console.log("Thực thi thành công: ' . addslashes(substr($query, 0, 50)) . '...");</script>';
                            } catch (PDOException $sqlEx) {
                                echo '<script>console.log("Lỗi thực thi SQL: ' . addslashes($sqlEx->getMessage()) . '");</script>';
                            }
                        }
                    }
                    echo '<script>console.log("Đã tạo các bảng từ file schema");</script>';
                } else {
                    echo '<script>console.log("Không tìm thấy file schema SQL");</script>';
                }
            }
            
            // Kết nối đến cơ sở dữ liệu đã chỉ định
            $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
            echo '<script>console.log("Kết nối thành công đến cơ sở dữ liệu ' . DB_NAME . '");</script>';
        } catch (PDOException $e) {
            // Xử lý lỗi kết nối
            echo '<script>console.log("Lỗi kết nối cơ sở dữ liệu: ' . addslashes($e->getMessage()) . '");</script>';
            die("Kết nối cơ sở dữ liệu thất bại: {$e->getMessage()}. Vui lòng thử lại sau.");
        }
    }

    // Hủy kết nối CSDL
    public function __destruct()
    {
        $this->pdo = null;
    }
}
