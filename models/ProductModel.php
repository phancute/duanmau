<?php

class ProductModel extends BaseModel
{
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
    }

    // Lấy tất cả sản phẩm
    public function getAll()
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy sản phẩm theo ID
    public function getById($id)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Lấy sản phẩm theo danh mục
    public function getByCategory($categoryId)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :category_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Thêm sản phẩm mới
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (name, description, specifications, price, image_url, category_id, stock) 
                VALUES 
                (:name, :description, :specifications, :price, :image_url, :category_id, :stock)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(':specifications', $data['specifications'], PDO::PARAM_STR);
        $stmt->bindParam(':price', $data['price'], PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $data['image_url'], PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Cập nhật sản phẩm
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET 
                name = :name, 
                description = :description, 
                specifications = :specifications, 
                price = :price, 
                image_url = :image_url, 
                category_id = :category_id, 
                stock = :stock 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(':specifications', $data['specifications'], PDO::PARAM_STR);
        $stmt->bindParam(':price', $data['price'], PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $data['image_url'], PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Cập nhật số lượng sản phẩm
    public function updateStock($id, $quantity)
    {
        $sql = "UPDATE {$this->table} SET stock = :stock WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':stock', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Xóa sản phẩm
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Tìm kiếm sản phẩm
    public function search($keyword)
    {
        $keyword = "%$keyword%";
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.name LIKE :keyword OR p.description LIKE :keyword";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}