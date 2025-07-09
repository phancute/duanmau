<?php

class CommentModel extends BaseModel
{
    protected $table = 'comments';

    public function __construct()
    {
        parent::__construct();
    }

    // Lấy tất cả bình luận
    public function getAll()
    {
        $sql = "SELECT c.*, u.username, p.name as product_name 
                FROM {$this->table} c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN products p ON c.product_id = p.id 
                ORDER BY c.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy bình luận theo ID
    public function getById($id)
    {
        $sql = "SELECT c.*, u.username, p.name as product_name 
                FROM {$this->table} c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN products p ON c.product_id = p.id 
                WHERE c.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Lấy bình luận theo sản phẩm
    public function getByProduct($productId, $approvedOnly = true)
    {
        $sql = "SELECT c.*, u.username 
                FROM {$this->table} c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.product_id = :product_id";
        
        if ($approvedOnly) {
            $sql .= " AND c.approved = 1";
        }
        
        $sql .= " ORDER BY c.created_at DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy bình luận theo người dùng
    public function getByUser($userId)
    {
        $sql = "SELECT c.*, p.name as product_name 
                FROM {$this->table} c 
                LEFT JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = :user_id 
                ORDER BY c.created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Thêm bình luận mới
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (user_id, product_id, content, approved) 
                VALUES (:user_id, :product_id, :content, :approved)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $data['product_id'], PDO::PARAM_INT);
        $stmt->bindParam(':content', $data['content'], PDO::PARAM_STR);
        $stmt->bindParam(':approved', $data['approved'], PDO::PARAM_BOOL);
        
        return $stmt->execute();
    }

    // Cập nhật trạng thái phê duyệt bình luận
    public function approve($id, $approved = true)
    {
        $sql = "UPDATE {$this->table} SET approved = :approved WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':approved', $approved, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Cập nhật nội dung bình luận
    public function update($id, $content)
    {
        $sql = "UPDATE {$this->table} SET content = :content WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Xóa bình luận
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    // Đếm số lượng bình luận chưa được phê duyệt
    public function countPendingComments()
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE approved = 0";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }
}