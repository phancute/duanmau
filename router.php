<?php
// Router cho PHP built-in server

// Kiểm tra xem request có phải là cho file tĩnh không
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if (file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri) && $uri != '/index.php') {
    // Nếu là file tĩnh, trả về file đó
    return false;
}

// Xử lý URL để tạo tham số cho index.php
$path = trim($uri, '/');
$segments = explode('/', $path);

// Thiết lập action và params mặc định
$_GET['action'] = '/';
$_GET['params'] = '';

// Xử lý các trường hợp URL khác nhau
if (empty($segments[0])) {
    // Trang chủ
    $_GET['action'] = '/';
} else if (count($segments) == 1) {
    // URL dạng /product
    $_GET['action'] = '/' . $segments[0];
} else if (count($segments) == 2) {
    // URL dạng /product/detail hoặc /product/1
    if ($segments[0] == 'product' && is_numeric($segments[1])) {
        // Trường hợp đặc biệt cho /product/1
        $_GET['action'] = '/product';
        $_GET['params'] = $segments[1];
    } else {
        // Trường hợp thông thường
        $_GET['action'] = '/' . $segments[0] . '/' . $segments[1];
    }
} else if (count($segments) == 3) {
    // URL dạng /product/detail/1
    if ($segments[0] == 'product' && $segments[1] == 'detail' && is_numeric($segments[2])) {
        // Trường hợp đặc biệt cho /product/detail/ID
        $_GET['action'] = '/product/detail';
        $_GET['params'] = $segments[2];
    } else {
        // Trường hợp thông thường
        $_GET['action'] = '/' . $segments[0] . '/' . $segments[1];
        $_GET['params'] = $segments[2];
    }
} else if (count($segments) == 4) {
    // URL dạng /admin/product/edit/1
    $_GET['action'] = '/' . $segments[0] . '/' . $segments[1] . '/' . $segments[2];
    $_GET['params'] = $segments[3];
}

// Bao gồm file index.php để xử lý request
require 'index.php';