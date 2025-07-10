<?php

// Lấy action từ URL (đã được xử lý trong index.php)

try {
    // Sử dụng match để điều hướng đến controller tương ứng
    $result = match ($action) {
        // Trang chủ
        '/'                         => (new HomeController)->index(),
        
        // Danh mục
        '/categories'               => (new CategoryController)->index(),
        '/categories/detail'        => (new CategoryController)->detail(isset($params[0]) ? $params[0] : null),
        
        // Sản phẩm
        '/products'                 => (new ProductController)->index(),
        '/product'                  => function() use ($params) {
            echo '<script>console.log("Route /product được gọi với params = ' . json_encode($params) . '");</script>';
            return (new ProductController)->detail(isset($params[0]) ? $params[0] : null);
        },
        '/product/detail'           => (new ProductController)->detail(isset($params[0]) ? $params[0] : null),
        '/product/category'         => (new ProductController)->category(isset($params[0]) ? $params[0] : null),
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
        '/admin/categories'         => (new CategoryAdminController)->index(),
        '/admin/categories/add'     => (new CategoryAdminController)->add(),
        '/admin/categories/edit'    => (new CategoryAdminController)->edit(isset($params[0]) ? $params[0] : null),
        '/admin/categories/delete'  => (new CategoryAdminController)->delete(isset($params[0]) ? $params[0] : null),
        
        '/admin/products'           => (new ProductAdminController)->index(),
        '/admin/product/add'        => (new ProductAdminController)->add(),
        '/admin/product/edit'       => (new ProductAdminController)->edit(isset($params[0]) ? $params[0] : null),
        '/admin/product/delete'     => (new ProductAdminController)->delete(isset($params[0]) ? $params[0] : null),
        
        '/admin/comments'           => (new AdminController)->comments(),
        '/admin/comment/approve'    => (new AdminController)->approveComment(isset($params[0]) ? $params[0] : null),
        '/admin/comment/reject'     => (new AdminController)->rejectComment(isset($params[0]) ? $params[0] : null),
        
        '/admin/users'              => (new AdminController)->users(),
        '/admin/user/toggle-status' => (new AdminController)->toggleUserStatus(isset($params[0]) ? $params[0] : null),
        
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