<?php

// Môi trường ứng dụng: development, testing, production
define('ENVIRONMENT', 'development');

// Cấu hình hiển thị lỗi dựa trên môi trường
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// URL cơ sở
define('BASE_URL', 'http://localhost/BaseExam/');

// Đường dẫn thư mục
define('PATH_ROOT',         __DIR__ . '/../');
define('PATH_VIEW',         PATH_ROOT . 'views/');
define('PATH_VIEW_MAIN',    PATH_ROOT . 'views/main.php');
define('PATH_VIEW_ADMIN',   PATH_ROOT . 'views/admin.php');
define('BASE_ASSETS_UPLOADS',   BASE_URL . 'assets/uploads/');
define('PATH_ASSETS_UPLOADS',   PATH_ROOT . 'assets/uploads/');
define('PATH_CONTROLLER',       PATH_ROOT . 'controllers/');
define('PATH_MODEL',            PATH_ROOT . 'models/');

// Cấu hình cơ sở dữ liệu
define('DB_HOST',     'localhost');
define('DB_PORT',     '3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME',     'polyshop');
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

// Cấu hình ứng dụng
define('APP_NAME', 'BaseExam Shop');
define('APP_VERSION', '1.0.0');
define('APP_DESCRIPTION', 'Hệ thống quản lý sản phẩm');
define('APP_KEYWORDS', 'shop, ecommerce, products, categories');
define('APP_AUTHOR', 'BaseExam Team');

// Cấu hình upload
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif']);

// Cấu hình phân trang
define('ITEMS_PER_PAGE', 12);
define('ADMIN_ITEMS_PER_PAGE', 20);
