<?php
// Tải cấu hình môi trường
require_once 'configs/env.php';

// Tải các model
require_once PATH_MODEL . 'BaseModel.php';
require_once PATH_MODEL . 'ConnectModel.php';
require_once PATH_MODEL . 'ProductModel.php';

// Tạo đối tượng ProductModel
$productModel = new ProductModel();

// Lấy sản phẩm có ID = 1
$product = $productModel->getById(1);

// Hiển thị thông tin sản phẩm
echo '<h1>Test Database Connection</h1>';

if ($product) {
    echo '<h2>Product found:</h2>';
    echo '<pre>';
    print_r($product);
    echo '</pre>';
} else {
    echo '<h2>Product not found!</h2>';
}