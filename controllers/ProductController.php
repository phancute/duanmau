<?php

class ProductController
{
    private $productModel;
    private $categoryModel;
    private $commentModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->commentModel = new CommentModel();
    }
    
    /**
     * Hiển thị danh sách tất cả sản phẩm
     */
    public function index()
    {
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        
        $title = 'Sản phẩm - PolyShop';
        $view = 'product_list';
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Hiển thị chi tiết sản phẩm
     */
    public function detail($id)
    {
        $product = $this->productModel->getById($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm';
            header('Location: ' . BASE_URL . 'product');
            exit;
        }
        
        // Lấy danh sách bình luận đã được phê duyệt
        $comments = $this->commentModel->getByProduct($id, true);
        
        // Lấy sản phẩm liên quan (cùng danh mục)
        $relatedProducts = $this->productModel->getByCategory($product['category_id']);
        
        // Loại bỏ sản phẩm hiện tại khỏi danh sách sản phẩm liên quan
        foreach ($relatedProducts as $key => $relatedProduct) {
            if ($relatedProduct['id'] == $id) {
                unset($relatedProducts[$key]);
                break;
            }
        }
        
        // Giới hạn số lượng sản phẩm liên quan
        $relatedProducts = array_slice($relatedProducts, 0, 4);
        
        $title = $product['name'] . ' - PolyShop';
        $view = 'product_detail';
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Hiển thị sản phẩm theo danh mục
     */
    public function category($categoryId)
    {
        // Chuyển hướng đến CategoryController
        header('Location: ' . BASE_URL . 'category/detail/' . $categoryId);
        exit;
    }
    
    /**
     * Tìm kiếm sản phẩm
     */
    public function search()
    {
        $keyword = $_GET['keyword'] ?? '';
        
        if (empty($keyword)) {
            header('Location: ' . BASE_URL . 'product');
            exit;
        }
        
        $products = $this->productModel->search($keyword);
        $categories = $this->categoryModel->getAll();
        
        $title = 'Kết quả tìm kiếm: ' . $keyword . ' - PolyShop';
        $view = 'product_list';
        $searchKeyword = $keyword;
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Thêm bình luận cho sản phẩm
     */
    public function addComment()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để bình luận';
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
        
        // Kiểm tra phương thức POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL);
            exit;
        }
        
        $productId = $_POST['product_id'] ?? 0;
        $content = $_POST['content'] ?? '';
        
        // Validate dữ liệu
        $errors = [];
        
        if (empty($productId)) {
            $errors[] = 'Sản phẩm không hợp lệ';
        }
        
        if (empty($content)) {
            $errors[] = 'Nội dung bình luận không được để trống';
        }
        
        if (empty($errors)) {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'product_id' => $productId,
                'content' => $content,
                'approved' => 0 // Chờ phê duyệt
            ];
            
            $result = $this->commentModel->create($data);
            
            if ($result) {
                $_SESSION['success'] = 'Bình luận của bạn đã được gửi và đang chờ phê duyệt';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi gửi bình luận';
            }
        } else {
            $_SESSION['error'] = implode('<br>', $errors);
        }
        
        header('Location: ' . BASE_URL . 'product/detail/' . $productId);
        exit;
    }
    
    /**
     * Hiển thị form thêm sản phẩm (chỉ admin)
     */
    public function add()
    {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $_SESSION['error'] = 'Bạn không có quyền thực hiện chức năng này';
            header('Location: ' . BASE_URL . 'product');
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
            
            // Xử lý upload ảnh
            $imageUrl = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PATH_ASSETS_UPLOADS;
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imageUrl = BASE_ASSETS_UPLOADS . $fileName;
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
                    'stock' => $stock
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
        $formAction = BASE_URL . 'product/add';
        $product = [
            'name' => '',
            'description' => '',
            'specifications' => '',
            'price' => '',
            'image_url' => '',
            'category_id' => '',
            'stock' => ''
        ];
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Hiển thị form cập nhật sản phẩm (chỉ admin)
     */
    public function edit($id)
    {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $_SESSION['error'] = 'Bạn không có quyền thực hiện chức năng này';
            header('Location: ' . BASE_URL . 'product');
            exit;
        }
        
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
            
            // Xử lý upload ảnh
            $imageUrl = $product['image_url']; // Giữ nguyên ảnh cũ nếu không upload ảnh mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = PATH_ASSETS_UPLOADS;
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $imageUrl = BASE_ASSETS_UPLOADS . $fileName;
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
            
            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description,
                    'specifications' => $specifications,
                    'price' => $price,
                    'image_url' => $imageUrl,
                    'category_id' => $categoryId,
                    'stock' => $stock
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
        $formAction = BASE_URL . 'product/edit/' . $id;
        
        require_once PATH_VIEW . 'main.php';
    }
    
    /**
     * Xóa sản phẩm (chỉ admin)
     */
    public function delete($id)
    {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $_SESSION['error'] = 'Bạn không có quyền thực hiện chức năng này';
            header('Location: ' . BASE_URL . 'product');
            exit;
        }
        
        $product = $this->productModel->getById($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm';
            header('Location: ' . BASE_URL . 'admin/products');
            exit;
        }
        
        $result = $this->productModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Xóa sản phẩm thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa sản phẩm';
        }
        
        header('Location: ' . BASE_URL . 'admin/products');
        exit;
    }
}