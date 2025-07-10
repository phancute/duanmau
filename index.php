<?php
// Khởi tạo session
session_start();

// Tải cấu hình môi trường
require_once 'configs/env.php';

// Tải các hàm helper
require_once 'configs/helper.php';

// Tải các model
require_once PATH_MODEL . 'BaseModel.php';
require_once PATH_MODEL . 'ConnectModel.php';
require_once PATH_MODEL . 'UserModel.php';
require_once PATH_MODEL . 'CategoryModel.php';
require_once PATH_MODEL . 'ProductModel.php';
require_once PATH_MODEL . 'CommentModel.php';

// Tải các controller
require_once PATH_CONTROLLER . 'HomeController.php';
require_once PATH_CONTROLLER . 'CategoryController.php';
require_once PATH_CONTROLLER . 'ProductController.php';
require_once PATH_CONTROLLER . 'UserController.php';
require_once PATH_CONTROLLER . 'AdminController.php';
require_once PATH_CONTROLLER . 'CategoryAdminController.php';
require_once PATH_CONTROLLER . 'ProductAdminController.php';

// Lấy action từ URL
$action = isset($_GET['action']) ? $_GET['action'] : '/';

// Xử lý các tham số trong URL
$params = [];
if (isset($_GET['params']) && !empty($_GET['params'])) {
    $params = explode('/', $_GET['params']);
}

// Tải router
require_once 'routes/index.php';