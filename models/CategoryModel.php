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
        $sql = "INSERT INTO {$this->table} (name, description) VALUES (:name, :description)";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    // Cập nhật danh mục
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET name = :name, description = :description WHERE id = :id";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Xóa danh mục
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
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