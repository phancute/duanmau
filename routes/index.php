<?php

// Lấy action từ URL (đã được xử lý trong index.php)

try {
    // Sử dụng match để điều hướng đến controller tương ứng
    $result = match ($action) {
        // Trang chủ
        '/'                         => (new HomeController)->index(),
        
        // Danh mục
        '/categories'               => (new CategoryController)->index(),
        '/category/detail'          => (new CategoryController)->detail(),
        
        // Sản phẩm
        '/products'                 => (new ProductController)->index(),
        '/product/detail'           => (new ProductController)->detail(),
        '/product/category'         => (new ProductController)->category(),
        '/product/search'           => (new ProductController)->search(),
        '/product/add-comment'      => (new ProductController)->addComment(),
        
        // Người dùng
        '/register'                 => (new UserController)->register(),
        '/login'                    => (new UserController)->login(),
        '/logout'                   => (new UserController)->logout(),
        '/profile'                  => (new UserController)->profile(),
        '/change-password'          => (new UserController)->changePassword(),
        
        // Admin
        '/admin'                    => (new AdminController)->index(),
        '/admin/categories'         => (new AdminController)->categories(),
        '/admin/category/add'       => (new CategoryController)->add(),
        '/admin/category/edit'      => (new CategoryController)->edit(),
        '/admin/category/delete'    => (new CategoryController)->delete(),
        
        '/admin/products'           => (new AdminController)->products(),
        '/admin/product/add'        => (new ProductController)->add(),
        '/admin/product/edit'       => (new ProductController)->edit(),
        '/admin/product/delete'     => (new ProductController)->delete(),
        
        '/admin/comments'           => (new AdminController)->comments(),
        '/admin/comment/approve'    => (new AdminController)->approveComment(),
        '/admin/comment/reject'     => (new AdminController)->rejectComment(),
        
        '/admin/users'              => (new AdminController)->users(),
        '/admin/user/toggle-status' => (new AdminController)->toggleUserStatus(),
        
        '/admin/reports'            => (new AdminController)->reports(),
        
        // Xử lý route không tồn tại
        default => function() {
            // Thiết lập header 404
            header("HTTP/1.0 404 Not Found");
            
            // Hiển thị trang lỗi 404
            $title = 'Không tìm thấy trang';
            $view = '404';
            
            // Sử dụng layout chính
            require_once PATH_VIEW_MAIN;
            exit;
        }
    };
    
    // Nếu controller trả về kết quả, hiển thị nó
    if (is_string($result)) {
        echo $result;
    }
    
} catch (Exception $e) {
    // Xử lý lỗi
    header("HTTP/1.0 500 Internal Server Error");
    
    // Hiển thị trang lỗi 500 nếu không phải môi trường production
    if (defined('ENVIRONMENT') && ENVIRONMENT !== 'production') {
        echo '<h1>Lỗi hệ thống</h1>';
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        // Trong môi trường production, hiển thị thông báo lỗi chung
        $title = 'Lỗi hệ thống';
        $view = '500';
        
        // Sử dụng layout chính
        require_once PATH_VIEW_MAIN;
    }
    
    exit;
}