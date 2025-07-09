<?php

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $rememberTokensTable = 'remember_tokens';

    public function __construct()
    {
        parent::__construct();
    }

    // Lấy tất cả người dùng
    public function getAll()
    {
        $sql = "SELECT id, username, email, role, created_at FROM {$this->table}";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy người dùng theo ID
    public function getById($id)
    {
        $sql = "SELECT id, username, email, role, created_at FROM {$this->table} WHERE id = :id";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Lấy người dùng theo username
    public function getByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Lấy người dùng theo email
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Đăng ký người dùng mới
    public function register($data)
    {
        try {
            // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            
            // Kiểm tra kết nối cơ sở dữ liệu
            if (!$this->getPdo()) {
                error_log("Lỗi: Không có kết nối PDO");
                echo '<script>console.log("Lỗi: Không có kết nối PDO");</script>';
                return false;
            }
            
            // Kiểm tra cơ sở dữ liệu có tồn tại không
            try {
                $checkDb = $this->getPdo()->query("SELECT DATABASE()");
                $dbName = $checkDb->fetchColumn();
                error_log("Đang sử dụng cơ sở dữ liệu: " . $dbName);
                echo '<script>console.log("Đang sử dụng cơ sở dữ liệu: ' . $dbName . '");</script>';
                
                if (empty($dbName)) {
                    error_log("Lỗi: Không có cơ sở dữ liệu được chọn");
                    echo '<script>console.log("Lỗi: Không có cơ sở dữ liệu được chọn");</script>';
                    return false;
                }
            } catch (PDOException $e) {
                error_log("Lỗi kiểm tra cơ sở dữ liệu: " . $e->getMessage());
                echo '<script>console.log("Lỗi kiểm tra cơ sở dữ liệu: ' . addslashes($e->getMessage()) . '");</script>';
                return false;
            }
            
            // Kiểm tra bảng users có tồn tại không
            try {
                $checkTable = $this->getPdo()->query("SHOW TABLES LIKE '{$this->table}'");
                if ($checkTable->rowCount() == 0) {
                    error_log("Lỗi: Bảng {$this->table} không tồn tại");
                    echo '<script>console.log("Lỗi: Bảng ' . $this->table . ' không tồn tại");</script>';
                    return false;
                }
            } catch (PDOException $e) {
                error_log("Lỗi kiểm tra bảng: " . $e->getMessage());
                echo '<script>console.log("Lỗi kiểm tra bảng: ' . addslashes($e->getMessage()) . '");</script>';
                return false;
            }
            
            // Kiểm tra cấu trúc bảng
            $tableInfo = $this->getPdo()->query("DESCRIBE {$this->table}");
            $columns = $tableInfo->fetchAll(PDO::FETCH_COLUMN);
            error_log("Cấu trúc bảng users: " . implode(", ", $columns));
            echo '<script>console.log("Cấu trúc bảng users: ' . implode(", ", $columns) . '");</script>';

            
            // Xây dựng câu lệnh SQL dựa trên cấu trúc bảng thực tế
            $fields = [];
            $placeholders = [];
            $params = [];
            
            // Các trường cơ bản
            if (in_array('username', $columns)) {
                $fields[] = 'username';
                $placeholders[] = ':username';
                $params[':username'] = $data['username'];
            }
            
            if (in_array('email', $columns)) {
                $fields[] = 'email';
                $placeholders[] = ':email';
                $params[':email'] = $data['email'];
            }
            
            if (in_array('password', $columns)) {
                $fields[] = 'password';
                $placeholders[] = ':password';
                $params[':password'] = $hashedPassword;
            }
            
            if (in_array('role', $columns)) {
                $fields[] = 'role';
                $placeholders[] = ':role';
                $params[':role'] = $data['role'];
            }
            
            if (in_array('active', $columns)) {
                $fields[] = 'active';
                $placeholders[] = ':active';
                $params[':active'] = 1; // Mặc định là active
            }
            
            // Tạo câu lệnh SQL
            $sql = "INSERT INTO {$this->table} (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $placeholders) . ")";
            error_log("SQL đăng ký: " . $sql);
            echo '<script>console.log("SQL đăng ký: ' . addslashes($sql) . '");</script>';
            
            $stmt = $this->getPdo()->prepare($sql);
            
            // Bind các tham số
            foreach ($params as $key => $value) {
                $paramType = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue($key, $value, $paramType);
                echo '<script>console.log("Binding parameter: ' . $key . ' = ' . (is_int($value) ? $value : '\''.addslashes($value).'\''). '");</script>';
            }
            
            try {
                $result = $stmt->execute();
                
                // Lấy ID của người dùng vừa đăng ký
                if ($result) {
                    $userId = $this->getPdo()->lastInsertId();
                    error_log("Đăng ký thành công, ID người dùng: " . $userId);
                    echo '<script>console.log("Đăng ký thành công, ID người dùng: ' . $userId . '");</script>';
                    
                    // Ghi log để debug
                    error_log("Đăng ký người dùng: thành công");
                    
                    return $userId; // Trả về ID người dùng thay vì chỉ trả về true
                } else {
                    // Kiểm tra lỗi SQL
                    $errorInfo = $stmt->errorInfo();
                    error_log("Lỗi SQL: " . json_encode($errorInfo));
                    echo '<script>console.log("Lỗi SQL: ' . addslashes(json_encode($errorInfo)) . '");</script>';
                }
                
                // Ghi log để debug
                error_log("Đăng ký người dùng: thất bại");
                echo '<script>console.log("Đăng ký người dùng: thất bại");</script>';
                
                return false;
            } catch (PDOException $e) {
                // Ghi log lỗi
                error_log("Lỗi execute SQL: " . $e->getMessage());
                echo '<script>console.log("Lỗi execute SQL: ' . addslashes($e->getMessage()) . '");</script>';
                return false;
            }
        } catch (PDOException $e) {
            // Ghi log lỗi
            error_log("Lỗi đăng ký: " . $e->getMessage());
            echo '<script>console.log("Lỗi đăng ký: ' . addslashes($e->getMessage()) . '");</script>';
            return false;
        }
    }

    // Kiểm tra đăng nhập
    public function login($username, $password)
    {
        $user = $this->getByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }

    // Cập nhật thông tin người dùng
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET username = :username, email = :email";
        $params = [
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':id' => $id
        ];
        
        // Nếu có cập nhật mật khẩu
        if (!empty($data['password'])) {
            $sql .= ", password = :password";
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        // Nếu có cập nhật quyền
        if (!empty($data['role'])) {
            $sql .= ", role = :role";
            $params[':role'] = $data['role'];
        }
        
        $sql .= " WHERE id = :id";
        
        $stmt = $this->getPdo()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        
        return $stmt->execute();
    }

    // Xóa người dùng
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    // Lưu token ghi nhớ đăng nhập
    public function saveRememberToken($userId, $token, $expiryTimestamp)
    {
        // Xóa token cũ nếu có
        $this->deleteRememberTokensByUserId($userId);
        
        // Chuyển đổi timestamp thành định dạng datetime
        $expiryDate = date('Y-m-d H:i:s', $expiryTimestamp);
        
        $sql = "INSERT INTO {$this->rememberTokensTable} (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->bindParam(':expires_at', $expiryDate, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    // Lấy thông tin token ghi nhớ đăng nhập
    public function getRememberToken($token)
    {
        $sql = "SELECT * FROM {$this->rememberTokensTable} WHERE token = :token AND expires_at > NOW()";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }
    
    // Xóa token ghi nhớ đăng nhập
    public function deleteRememberToken($token)
    {
        $sql = "DELETE FROM {$this->rememberTokensTable} WHERE token = :token";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    
    // Xóa tất cả token của một người dùng
    public function deleteRememberTokensByUserId($userId)
    {
        $sql = "DELETE FROM {$this->rememberTokensTable} WHERE user_id = :user_id";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    // Cập nhật mật khẩu
    public function updatePassword($userId, $hashedPassword)
    {
        $sql = "UPDATE {$this->table} SET password = :password WHERE id = :id";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    // Đếm tổng số người dùng
    public function countAll()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";  
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }
    
    // Lấy người dùng mới nhất
    public function getLatest($limit = 5)
    {
        $sql = "SELECT id, username, email, role, created_at 
                FROM {$this->table} 
                ORDER BY id DESC 
                LIMIT :limit";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Lấy thống kê đăng ký người dùng theo tháng
    public function getRegistrationStats()
    {
        $sql = "SELECT 
                    MONTH(created_at) as month, 
                    YEAR(created_at) as year, 
                    COUNT(*) as count 
                FROM {$this->table} 
                GROUP BY YEAR(created_at), MONTH(created_at) 
                ORDER BY YEAR(created_at) ASC, MONTH(created_at) ASC";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}