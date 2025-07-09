<?php 

// Bắt đầu session
session_start();

// Thiết lập các header bảo mật
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');

// Tải các file cấu hình
require_once './configs/env.php';
require_once './configs/helper.php';

// Đăng ký autoloader
spl_autoload_register(function ($class) {    
    $fileName = "$class.php";

    $fileModel      = PATH_MODEL . $fileName;
    $fileController = PATH_CONTROLLER . $fileName;

    if (is_readable($fileModel)) {
        require_once $fileModel;
    } 
    else if (is_readable($fileController)) {
        require_once $fileController;
    }
});

// Xử lý flash messages
if (!isset($_SESSION['_flash'])) {
    $_SESSION['_flash'] = [];
}

// Lấy action từ URL
$action = $_GET['action'] ?? '/';

// Xử lý CSRF protection cho các request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // Nếu không có token hoặc token không khớp, chuyển hướng về trang chủ
        redirect('');
        exit;
    }
}

// Tạo CSRF token mới cho mỗi request
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Điều hướng
require_once './routes/index.php';
