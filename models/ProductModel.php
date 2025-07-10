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
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy tất cả sản phẩm với thông tin danh mục
    public function getAllWithCategory()
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.id DESC";
        $stmt = $this->getPdo()->prepare($sql);
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
        $stmt = $this->getPdo()->prepare($sql);
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
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Thêm sản phẩm mới
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (name, description, specifications, price, image_url, category_id, stock, status, featured, discount) 
                VALUES 
                (:name, :description, :specifications, :price, :image_url, :category_id, :stock, :status, :featured, :discount)";
        
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(':specifications', $data['specifications'], PDO::PARAM_STR);
        $stmt->bindParam(':price', $data['price'], PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $data['image_url'], PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':status', $data['status'], PDO::PARAM_INT);
        $stmt->bindParam(':featured', $data['featured'], PDO::PARAM_INT);
        $stmt->bindParam(':discount', $data['discount'], PDO::PARAM_INT);
        
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
                stock = :stock, 
                status = :status, 
                featured = :featured, 
                discount = :discount 
                WHERE id = :id";
        
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $stmt->bindParam(':specifications', $data['specifications'], PDO::PARAM_STR);
        $stmt->bindParam(':price', $data['price'], PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $data['image_url'], PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $data['category_id'], PDO::PARAM_INT);
        $stmt->bindParam(':stock', $data['stock'], PDO::PARAM_INT);
        $stmt->bindParam(':status', $data['status'], PDO::PARAM_INT);
        $stmt->bindParam(':featured', $data['featured'], PDO::PARAM_INT);
        $stmt->bindParam(':discount', $data['discount'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Cập nhật số lượng sản phẩm
    public function updateStock($id, $quantity)
    {
        $sql = "UPDATE {$this->table} SET stock = :stock WHERE id = :id";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':stock', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Xóa sản phẩm
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->getPdo()->prepare($sql);
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
        
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Đếm tổng số sản phẩm
    public function countAll()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }
    
    // Lấy sản phẩm mới nhất
    public function getLatest($limit = 5)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC 
                LIMIT :limit";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Lấy sản phẩm nổi bật (sản phẩm có giảm giá hoặc có lượt xem cao)
    public function getFeatured($limit = 5)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.discount > 0 OR p.status = 1 
                ORDER BY p.discount DESC, p.price DESC 
                LIMIT :limit";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
    // Đếm số lượng sản phẩm theo danh mục
    public function countByCategory($categoryId = null)
    {
        if ($categoryId !== null) {
            // Đếm số sản phẩm cho một danh mục cụ thể
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE category_id = :category_id";
            $stmt = $this->getPdo()->prepare($sql);
            $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchColumn();
        } else {
            // Đếm số sản phẩm cho tất cả các danh mục
            $sql = "SELECT c.id, c.name, COUNT(p.id) as count 
                    FROM categories c 
                    LEFT JOIN {$this->table} p ON c.id = p.category_id 
                    GROUP BY c.id, c.name 
                    ORDER BY c.name ASC";
            $stmt = $this->getPdo()->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll();
        }
    }
}