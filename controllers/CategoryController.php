<?php

class CategoryController
{
    private $categoryModel;
    private $productModel;
    
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }
    
    /**
     * Hiển thị danh sách tất cả danh mục
     */
    public function index()
    {
        $categories = $this->categoryModel->getAll();
        
        $title = 'Danh mục sản phẩm - PolyShop';
        $view = 'category_list';
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Hiển thị chi tiết danh mục và sản phẩm thuộc danh mục
     */
    public function detail($id)
    {
        $category = $this->categoryModel->getById($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy danh mục';
            header('Location: ' . BASE_URL . 'category');
            exit;
        }
        
        $products = $this->productModel->getByCategory($id);
        
        $title = $category['name'] . ' - PolyShop';
        $view = 'category_detail';
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Hiển thị form thêm danh mục (chỉ admin)
     */
    public function add()
    {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $_SESSION['error'] = 'Bạn không có quyền thực hiện chức năng này';
            header('Location: ' . BASE_URL . 'category');
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
                
                $result = $this->categoryModel->create($data);
                
                if ($result) {
                    $_SESSION['success'] = 'Thêm danh mục thành công';
                    header('Location: ' . BASE_URL . 'category');
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
        $formAction = BASE_URL . 'category/add';
        $category = ['name' => '', 'description' => ''];
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Hiển thị form cập nhật danh mục (chỉ admin)
     */
    public function edit($id)
    {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $_SESSION['error'] = 'Bạn không có quyền thực hiện chức năng này';
            header('Location: ' . BASE_URL . 'category');
            exit;
        }
        
        $category = $this->categoryModel->getById($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy danh mục';
            header('Location: ' . BASE_URL . 'category');
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
                    header('Location: ' . BASE_URL . 'category');
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
        $formAction = BASE_URL . 'category/edit/' . $id;
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Xóa danh mục (chỉ admin)
     */
    public function delete($id)
    {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $_SESSION['error'] = 'Bạn không có quyền thực hiện chức năng này';
            header('Location: ' . BASE_URL . 'category');
            exit;
        }
        
        $category = $this->categoryModel->getById($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy danh mục';
            header('Location: ' . BASE_URL . 'category');
            exit;
        }
        
        // Kiểm tra xem có sản phẩm nào thuộc danh mục này không
        $products = $this->productModel->getByCategory($id);
        
        if (!empty($products)) {
            $_SESSION['error'] = 'Không thể xóa danh mục này vì có sản phẩm thuộc danh mục';
            header('Location: ' . BASE_URL . 'category');
            exit;
        }
        
        $result = $this->categoryModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Xóa danh mục thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa danh mục';
        }
        
        header('Location: ' . BASE_URL . 'category');
        exit;
    }
}