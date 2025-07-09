<?php

class UserModel extends BaseModel
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    // Lấy tất cả người dùng
    public function getAll()
    {
        $sql = "SELECT id, username, email, role, created_at FROM {$this->table}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy người dùng theo ID
    public function getById($id)
    {
        $sql = "SELECT id, username, email, role, created_at FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Lấy người dùng theo username
    public function getByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Lấy người dùng theo email
    public function getByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Đăng ký người dùng mới
    public function register($data)
    {
        // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO {$this->table} (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':role', $data['role'], PDO::PARAM_STR);
        
        return $stmt->execute();
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
        
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        
        return $stmt->execute();
    }

    // Xóa người dùng
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}