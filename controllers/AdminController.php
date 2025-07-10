<?php

class AdminController
{
    private $userModel;
    private $categoryModel;
    private $productModel;
    private $commentModel;
    
    public function __construct()
    {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error'] = 'Bạn không có quyền truy cập trang quản trị';
            header('Location: ' . BASE_URL);
            exit;
        }
        
        // Thiết lập biến is_admin cho các controller khác sử dụng
        $_SESSION['is_admin'] = true;
        
        $this->userModel = new UserModel();
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
        $this->commentModel = new CommentModel();
    }
    
    /**
     * Hiển thị trang tổng quan
     */
    public function index()
    {
        $totalProducts = $this->productModel->countAll();
        $totalCategories = $this->categoryModel->countAll();
        $totalUsers = $this->userModel->countAll();
        $pendingComments = $this->commentModel->countPending();
        $totalComments = $this->commentModel->countAll();
        
        $latestProducts = $this->productModel->getLatest(5);
        $latestComments = $this->commentModel->getLatest(5);
        $recentActivities = $this->getRecentActivities();
        $userRegistrationStats = $this->userModel->getRegistrationStats();
        $productsByCategory = $this->productModel->countByCategory();
        
        $title = 'Trang quản trị - PolyShop';
        $view = 'admin/dashboard';
        
        require_once PATH_VIEW . 'admin.php';
    }
    
    /**
     * Quản lý danh mục
     */
    public function categories()
    {
        // Lấy danh sách danh mục và đếm số sản phẩm trong mỗi danh mục
        $categories = $this->categoryModel->getAll();
        
        // Đếm số sản phẩm trong mỗi danh mục
        foreach ($categories as &$category) {
            $category['product_count'] = $this->productModel->countByCategory($category['id']);
        }
        
        $title = 'Quản lý danh mục - PolyShop';
        $view = 'admin/categories';
        
        require_once PATH_VIEW . 'admin.php';
    }
    
    /**
     * Hiển thị form thêm danh mục
     */
    public function addCategory()
    {
        // Xử lý form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            
            // Validate dữ liệu
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Tên danh mục không được để trống';
            }
            
            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description
                ];
                
                $result = $this->categoryModel->create($data);
                
                if ($result) {
                    $_SESSION['success'] = 'Thêm danh mục thành công';
                    header('Location: ' . BASE_URL . 'admin/categories');
                    exit;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi thêm danh mục';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        $title = 'Thêm danh mục - PolyShop';
        $view = 'admin/category_form';
        $category = ['name' => '', 'description' => ''];
        
        require_once PATH_VIEW . 'admin.php';
    }
    
    /**
     * Hiển thị form cập nhật danh mục
     */
    public function editCategory($id)
    {
        $category = $this->categoryModel->getById($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy danh mục';
            header('Location: ' . BASE_URL . 'admin/categories');
            exit;
        }
        
        // Xử lý form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            
            // Validate dữ liệu
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Tên danh mục không được để trống';
            }
            
            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description
                ];
                
                $result = $this->categoryModel->update($id, $data);
                
                if ($result) {
                    $_SESSION['success'] = 'Cập nhật danh mục thành công';
                    header('Location: ' . BASE_URL . 'admin/categories');
                    exit;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật danh mục';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        $title = 'Cập nhật danh mục - PolyShop';
        $view = 'admin/category_form';
        
        require_once PATH_VIEW . 'admin.php';
    }
    
    /**
     * Xóa danh mục
     */
    public function deleteCategory($id)
    {
        $category = $this->categoryModel->getById($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy danh mục';
            header('Location: ' . BASE_URL . 'admin/categories');
            exit;
        }
        
        // Kiểm tra xem có sản phẩm nào thuộc danh mục này không
        $productCount = $this->productModel->countByCategory($id);
        
        if ($productCount > 0) {
            $_SESSION['error'] = 'Không thể xóa danh mục này vì có ' . $productCount . ' sản phẩm thuộc danh mục';
            header('Location: ' . BASE_URL . 'admin/categories');
            exit;
        }
        
        $result = $this->categoryModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Xóa danh mục thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa danh mục';
        }
        
        header('Location: ' . BASE_URL . 'admin/categories');
        exit;
    }
    
    /**
     * Quản lý sản phẩm
     */
    public function products()
    {
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        
        if ($categoryId) {
            $products = $this->productModel->getByCategory($categoryId);
            $category = $this->categoryModel->getById($categoryId);
            $title = 'Sản phẩm trong danh mục "' . $category['name'] . '" - PolyShop';
        } else {
            $products = $this->productModel->getAllWithCategory();
            $title = 'Quản lý sản phẩm - PolyShop';
        }
        
        $categories = $this->categoryModel->getAll();
        $view = 'admin/products';
        
        require_once PATH_VIEW . 'admin.php';
    }
    
    /**
     * Quản lý bình luận
     */
    public function comments()
    {
        $comments = $this->commentModel->getAllWithDetails();
        
        $title = 'Quản lý bình luận - PolyShop';
        $view = 'admin/comments';
        
        require_once PATH_VIEW . 'admin.php';
    }
    
    /**
     * Duyệt bình luận
     */
    public function approveComment($commentId)
    {
        $result = $this->commentModel->updateStatus($commentId, 1);
        
        if ($result) {
            $_SESSION['success'] = 'Đã duyệt bình luận thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi duyệt bình luận';
        }
        
        header('Location: ' . BASE_URL . 'admin/comments');
        exit;
    }
    
    /**
     * Từ chối bình luận
     */
    public function rejectComment($commentId)
    {
        $result = $this->commentModel->delete($commentId);
        
        if ($result) {
            $_SESSION['success'] = 'Đã xóa bình luận thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa bình luận';
        }
        
        header('Location: ' . BASE_URL . 'admin/comments');
        exit;
    }
    
    /**
     * Quản lý người dùng
     */
    public function users()
    {
        $users = $this->userModel->getAll();
        
        $title = 'Quản lý người dùng - PolyShop';
        $view = 'admin/users';
        
        require_once PATH_VIEW . 'admin.php';
    }
    
    /**
     * Kích hoạt/Vô hiệu hóa tài khoản người dùng
     */
    public function toggleUserStatus($userId)
    {
        // Không cho phép vô hiệu hóa tài khoản admin hiện tại
        if ($userId == $_SESSION['user_id']) {
            $_SESSION['error'] = 'Không thể thay đổi trạng thái tài khoản của chính bạn';
            header('Location: ' . BASE_URL . 'admin/users');
            exit;
        }
        
        $user = $this->userModel->getById($userId);
        
        if (!$user) {
            $_SESSION['error'] = 'Không tìm thấy người dùng';
            header('Location: ' . BASE_URL . 'admin/users');
            exit;
        }
        
        $newStatus = $user['active'] ? 0 : 1;
        $result = $this->userModel->updateStatus($userId, $newStatus);
        
        if ($result) {
            $message = $newStatus ? 'Đã kích hoạt tài khoản thành công' : 'Đã vô hiệu hóa tài khoản thành công';
            $_SESSION['success'] = $message;
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi thay đổi trạng thái tài khoản';
        }
        
        header('Location: ' . BASE_URL . 'admin/users');
        exit;
    }
    
    /**
     * Báo cáo và thống kê
     */
    public function reports()
    {
        $productsByCategory = $this->productModel->countByCategory();
        $userRegistrationStats = $this->userModel->getRegistrationStats();
        $commentStats = $this->commentModel->getMonthlyStats();
        
        $title = 'Báo cáo và thống kê - PolyShop';
        $view = 'admin/reports';
        
        require_once PATH_VIEW . 'admin.php';
    }
    
    /**
     * Lấy các hoạt động gần đây
     */
    private function getRecentActivities()
    {
        $activities = [];
        
        // Sản phẩm mới thêm
        $newProducts = $this->productModel->getLatest(3);
        foreach ($newProducts as $product) {
            $activities[] = [
                'type' => 'product',
                'message' => 'Sản phẩm mới: ' . $product['name'],
                'time' => $product['created_at'],
                'link' => BASE_URL . 'product/detail/' . $product['id']
            ];
        }
        
        // Người dùng mới đăng ký
        $newUsers = $this->userModel->getLatest(3);
        foreach ($newUsers as $user) {
            $activities[] = [
                'type' => 'user',
                'message' => 'Người dùng mới: ' . $user['username'],
                'time' => $user['created_at'],
                'link' => BASE_URL . 'admin/users'
            ];
        }
        
        // Bình luận mới
        $newComments = $this->commentModel->getLatest(3);
        foreach ($newComments as $comment) {
            $activities[] = [
                'type' => 'comment',
                'message' => 'Bình luận mới từ ' . $comment['username'] . ' cho sản phẩm ' . $comment['product_name'],
                'time' => $comment['created_at'],
                'link' => BASE_URL . 'admin/comments'
            ];
        }
        
        // Sắp xếp theo thời gian giảm dần
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        
        return array_slice($activities, 0, 5);
    }
}