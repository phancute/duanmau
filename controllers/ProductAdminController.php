<?php

class ProductAdminController
{
    private $productModel;
    private $categoryModel;
    
    public function __construct()
    {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error'] = 'Bạn không có quyền truy cập trang quản trị';
            header('Location: ' . BASE_URL);
            exit;
        }
        
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }
    
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index()
    {
        // Ghi log để debug
        error_log("ProductAdminController::index() được gọi");
        
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
     * Hiển thị form thêm sản phẩm
     */
    public function add()
    {
        // Ghi log để debug
        error_log("ProductAdminController::add() được gọi");
        
        $categories = $this->categoryModel->getAll();
        
        // Xử lý form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $specifications = $_POST['specifications'] ?? '';
            $price = $_POST['price'] ?? 0;
            $categoryId = $_POST['category_id'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;
            $featured = isset($_POST['featured']) ? 1 : 0;
            $discount = $_POST['discount'] ?? 0;
            
            // Xử lý upload ảnh
            $imageUrl = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PATH_ASSETS_UPLOADS;
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imageUrl = $fileName; // Lưu tên file vào database
                } else {
                    $errors[] = 'Không thể upload hình ảnh. Vui lòng thử lại.';
                }
            }
            
            // Validate dữ liệu
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Tên sản phẩm không được để trống';
            }
            
            if (empty($description)) {
                $errors[] = 'Mô tả sản phẩm không được để trống';
            }
            
            if (empty($price) || !is_numeric($price) || $price <= 0) {
                $errors[] = 'Giá sản phẩm không hợp lệ';
            }
            
            if (empty($categoryId)) {
                $errors[] = 'Vui lòng chọn danh mục';
            }
            
            if (empty($imageUrl)) {
                $errors[] = 'Vui lòng chọn ảnh sản phẩm';
            }
            
            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description,
                    'specifications' => $specifications,
                    'price' => $price,
                    'image_url' => $imageUrl,
                    'category_id' => $categoryId,
                    'stock' => $stock,
                    'status' => $status,
                    'featured' => $featured,
                    'discount' => $discount
                ];
                
                $result = $this->productModel->create($data);
                
                if ($result) {
                    $_SESSION['success'] = 'Thêm sản phẩm thành công';
                    header('Location: ' . BASE_URL . 'admin/products');
                    exit;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi thêm sản phẩm';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        $title = 'Thêm sản phẩm - PolyShop';
        $view = 'admin/product_form';
        $formAction = BASE_URL . 'admin/product/add';
        $product = [
            'name' => '',
            'description' => '',
            'specifications' => '',
            'price' => '',
            'image_url' => '',
            'category_id' => '',
            'stock' => '0',
            'status' => '1',
            'featured' => '0',
            'discount' => '0'
        ];
        
        require_once PATH_VIEW . 'admin.php';
    }
    
    /**
     * Hiển thị form cập nhật sản phẩm
     */
    public function edit($id)
    {
        // Ghi log để debug
        error_log("ProductAdminController::edit() được gọi với id=$id");
        
        $product = $this->productModel->getById($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm';
            header('Location: ' . BASE_URL . 'admin/products');
            exit;
        }
        
        $categories = $this->categoryModel->getAll();
        
        // Xử lý form submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $specifications = $_POST['specifications'] ?? '';
            $price = $_POST['price'] ?? 0;
            $categoryId = $_POST['category_id'] ?? 0;
            $stock = $_POST['stock'] ?? 0;
            $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;
            $featured = isset($_POST['featured']) ? 1 : 0;
            $discount = $_POST['discount'] ?? 0;
            
            // Xử lý upload ảnh
            $imageUrl = $product['image_url']; // Giữ nguyên ảnh cũ nếu không upload ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PATH_ASSETS_UPLOADS;
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    // Xóa ảnh cũ nếu có
                    if (!empty($product['image_url'])) {
                        $oldImagePath = $uploadDir . $product['image_url'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $imageUrl = $fileName; // Lưu tên file vào database
                } else {
                    $errors[] = 'Không thể upload hình ảnh. Vui lòng thử lại.';
                }
            }
            
            // Xử lý xóa ảnh
            if (isset($_POST['remove_image']) && $_POST['remove_image'] == 1) {
                // Xóa file ảnh cũ nếu có
                if (!empty($product['image_url'])) {
                    $oldImagePath = PATH_ASSETS_UPLOADS . $product['image_url'];
                    if (file_exists($oldImagePath)) {
                        if (unlink($oldImagePath)) {
                            // Xóa file thành công
                        } else {
                            // Ghi log nếu không xóa được file
                            error_log("Không thể xóa file ảnh: " . $oldImagePath);
                        }
                    }
                }
                $imageUrl = '';
            }
            
            // Validate dữ liệu
            $errors = [];
            
            if (empty($name)) {
                $errors[] = 'Tên sản phẩm không được để trống';
            }
            
            if (empty($description)) {
                $errors[] = 'Mô tả sản phẩm không được để trống';
            }
            
            if (empty($price) || !is_numeric($price) || $price <= 0) {
                $errors[] = 'Giá sản phẩm không hợp lệ';
            }
            
            if (empty($categoryId)) {
                $errors[] = 'Vui lòng chọn danh mục';
            }
            
            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description,
                    'specifications' => $specifications,
                    'price' => $price,
                    'image_url' => $imageUrl,
                    'category_id' => $categoryId,
                    'stock' => $stock,
                    'status' => $status,
                    'featured' => $featured,
                    'discount' => $discount
                ];
                
                $result = $this->productModel->update($id, $data);
                
                if ($result) {
                    $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
                    header('Location: ' . BASE_URL . 'admin/products');
                    exit;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật sản phẩm';
                }
            } else {
                $_SESSION['error'] = implode('<br>', $errors);
            }
        }
        
        $title = 'Cập nhật sản phẩm - PolyShop';
        $view = 'admin/product_form';
        $formAction = BASE_URL . 'admin/product/edit/' . $id;
        
        require_once PATH_VIEW . 'admin.php';
    }
    
    /**
     * Xóa sản phẩm
     */
    public function delete($id)
    {
        // Ghi log để debug
        error_log("ProductAdminController::delete() được gọi với id=$id");
        
        $product = $this->productModel->getById($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm';
            header('Location: ' . BASE_URL . 'admin/products');
            exit;
        }
        
        $result = $this->productModel->delete($id);
        
        if ($result) {
            // Xóa file ảnh nếu có
            if (!empty($product['image_url'])) {
                $imagePath = PATH_ASSETS_UPLOADS . $product['image_url'];
                if (file_exists($imagePath)) {
                    if (unlink($imagePath)) {
                        // Xóa file thành công
                    } else {
                        // Ghi log nếu không xóa được file
                        error_log("Không thể xóa file ảnh: " . $imagePath);
                    }
                }
            }
            
            $_SESSION['success'] = 'Xóa sản phẩm thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa sản phẩm';
        }
        
        header('Location: ' . BASE_URL . 'admin/products');
        exit;
    }
}