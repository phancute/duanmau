<?php

class CategoryAdminController
{
    private $categoryModel;
    private $productModel;
    
    public function __construct()
    {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error'] = 'Bạn không có quyền truy cập trang quản trị';
            header('Location: ' . BASE_URL);
            exit;
        }
        
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }
    
    /**
     * Hiển thị danh sách danh mục
     */
    public function index()
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
    public function add()
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
            
            // Xử lý upload hình ảnh
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
                $maxFileSize = 2 * 1024 * 1024; // 2MB
                
                if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                    $errors[] = 'Chỉ chấp nhận file hình ảnh (jpg, png, gif, svg)';
                } elseif ($_FILES['image']['size'] > $maxFileSize) {
                    $errors[] = 'Kích thước file không được vượt quá 2MB';
                } else {
                    // Tạo tên file ngẫu nhiên để tránh trùng lặp
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $filename = 'category_' . uniqid() . '.' . $extension;
                    $uploadPath = PATH_ROOT . 'assets/uploads/' . $filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $image = 'assets/uploads/' . $filename;
                    } else {
                        $errors[] = 'Không thể tải lên hình ảnh, vui lòng thử lại';
                    }
                }
            }
            
            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description,
                    'image' => $image
                ];
                
                // Thực hiện thêm danh mục mới
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
    public function edit($id)
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
            
            // Xử lý upload hình ảnh
            $data = [
                'name' => $name,
                'description' => $description
            ];
            
            // Kiểm tra nếu có yêu cầu xóa hình ảnh
            if (isset($_POST['remove_image']) && $_POST['remove_image'] == 1) {
                $data['image'] = null;
                
                // Xóa file hình ảnh cũ nếu tồn tại
                if (!empty($category['image']) && file_exists(PATH_ROOT . $category['image'])) {
                    unlink(PATH_ROOT . $category['image']);
                }
            }
            // Kiểm tra nếu có upload hình ảnh mới
            elseif (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
                $maxFileSize = 2 * 1024 * 1024; // 2MB
                
                if (!in_array($_FILES['image']['type'], $allowedTypes)) {
                    $errors[] = 'Chỉ chấp nhận file hình ảnh (jpg, png, gif, svg)';
                } elseif ($_FILES['image']['size'] > $maxFileSize) {
                    $errors[] = 'Kích thước file không được vượt quá 2MB';
                } else {
                    // Tạo tên file ngẫu nhiên để tránh trùng lặp
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $filename = 'category_' . uniqid() . '.' . $extension;
                    $uploadPath = PATH_ROOT . 'assets/uploads/' . $filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                        $data['image'] = 'assets/uploads/' . $filename;
                        
                        // Xóa file hình ảnh cũ nếu tồn tại
                        if (!empty($category['image']) && file_exists(PATH_ROOT . $category['image'])) {
                            unlink(PATH_ROOT . $category['image']);
                        }
                    } else {
                        $errors[] = 'Không thể tải lên hình ảnh, vui lòng thử lại';
                    }
                }
            }
            
            if (empty($errors)) {
                // Thực hiện cập nhật danh mục
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
    public function delete($id)
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
        
        // Thực hiện xóa danh mục
        $result = $this->categoryModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Xóa danh mục thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa danh mục';
        }
        
        header('Location: ' . BASE_URL . 'admin/categories');
        exit;
    }
}