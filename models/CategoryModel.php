<?php

class CategoryModel extends BaseModel
{
    protected $table = 'categories';

    public function __construct()
    {
        parent::__construct();
    }

    // Lấy tất cả danh mục
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy danh mục theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Thêm danh mục mới
    public function create($data)
    {
        try {
            $sql = "INSERT INTO {$this->table} (name, description, image) VALUES (:name, :description, :image)";
            $stmt = $this->getPdo()->prepare($sql);
            $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
            $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
            
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            // Ghi log lỗi nếu cần
            return false;
        }
    }

    // Cập nhật danh mục
    public function update($id, $data)
    {
        try {
            // Kiểm tra xem có cập nhật hình ảnh không
            if (isset($data['image'])) {
                $sql = "UPDATE {$this->table} SET name = :name, description = :description, image = :image WHERE id = :id";
                $stmt = $this->getPdo()->prepare($sql);
                $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
                $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
                $stmt->bindParam(':image', $data['image'], PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                $sql = "UPDATE {$this->table} SET name = :name, description = :description WHERE id = :id";
                $stmt = $this->getPdo()->prepare($sql);
                $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
                $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            }
            
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            // Ghi log lỗi nếu cần
            return false;
        }
    }

    // Xóa danh mục
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->getPdo()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            // Ghi log lỗi nếu cần
            return false;
        }
    }
    
    // Đếm tổng số danh mục
    public function countAll()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }
}