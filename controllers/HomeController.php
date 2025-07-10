<?php

class HomeController
{
    private $categoryModel;
    private $productModel;
    
    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }
    
    public function index() 
    {
        // Lấy tất cả danh mục
        $categories = $this->categoryModel->getAll();
        
        // Lấy số lượng sản phẩm cho mỗi danh mục
        $productCounts = $this->productModel->countByCategory();
        
        // Gán số lượng sản phẩm vào mảng danh mục
        $categoriesWithCount = [];
        foreach ($categories as $category) {
            $category['product_count'] = 0; // Mặc định là 0
            
            // Tìm số lượng sản phẩm tương ứng
            foreach ($productCounts as $count) {
                if ($count['id'] == $category['id']) {
                    $category['product_count'] = $count['count'];
                    break;
                }
            }
            
            // Gán đường dẫn hình ảnh mặc định nếu không có
            if (empty($category['image'])) {
                // Sử dụng hình ảnh mặc định dựa trên ID của danh mục
                $defaultImageIndex = ($category['id'] % 4) + 1; // Lấy số từ 1-4
                $category['image'] = 'assets/images/category' . $defaultImageIndex . '.jpg.svg';
            }
            
            $categoriesWithCount[] = $category;
        }
        
        // Lấy sản phẩm nổi bật
        $featured_products = $this->productModel->getFeatured(4);
        
        // Lấy sản phẩm mới nhất
        $latest_products = $this->productModel->getLatest(4);
        
        // Xử lý hình ảnh cho sản phẩm nổi bật
        foreach ($featured_products as &$product) {
            if (empty($product['image_url'])) {
                // Sử dụng hình ảnh mặc định dựa trên ID của sản phẩm
                $defaultImageIndex = ($product['id'] % 4) + 1; // Lấy số từ 1-4
                $product['image'] = 'assets/images/product' . $defaultImageIndex . '.jpg.svg';
            } else {
                $product['image'] = $product['image_url'];
            }
        }
        
        // Xử lý hình ảnh cho sản phẩm mới nhất
        foreach ($latest_products as &$product) {
            if (empty($product['image_url'])) {
                // Sử dụng hình ảnh mặc định dựa trên ID của sản phẩm
                $defaultImageIndex = ($product['id'] % 4) + 1; // Lấy số từ 1-4
                $product['image'] = 'assets/images/product' . $defaultImageIndex . '.jpg.svg';
            } else {
                $product['image'] = $product['image_url'];
            }
        }
        
        $title = 'PolyShop - Trang chủ';
        $view = 'home';
        $categories = $categoriesWithCount; // Gán lại biến categories để truyền vào view
        
        require_once PATH_VIEW . 'main.php';
    }
}