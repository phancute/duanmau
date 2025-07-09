<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- SEO Meta Tags -->
    <title><?= $title ?? APP_NAME ?></title>
    <meta name="description" content="<?= $description ?? APP_DESCRIPTION ?>">
    <meta name="keywords" content="<?= $keywords ?? APP_KEYWORDS ?>">
    <meta name="author" content="<?= APP_AUTHOR ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?= $title ?? APP_NAME ?>">
    <meta property="og:description" content="<?= $description ?? APP_DESCRIPTION ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= BASE_URL ?>">
    <meta property="og:image" content="<?= BASE_URL ?>assets/images/logo.png">
    
    <!-- Favicon -->
    <link rel="icon" href="<?= BASE_URL ?>assets/images/favicon.ico" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }
        
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 
                'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            background-color: #f8f9fc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color);
        }
        
        .navbar {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            background-color: white;
        }
        
        .nav-link {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color);
        }
        
        .dropdown-item.active, .dropdown-item:active {
            background-color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 24px;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
        
        footer {
            background-color: white;
            box-shadow: 0 -0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            padding: 2rem 0;
            margin-top: auto;
        }
        
        .footer-links a {
            color: var(--secondary-color);
            text-decoration: none;
            margin: 0 10px;
        }
        
        .footer-links a:hover {
            color: var(--primary-color);
        }
        
        .main-content {
            flex: 1;
            padding: 2rem 0;
        }
        
        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding: 0.75rem 0;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            content: "\f105";
            font-family: "bootstrap-icons";
            font-size: 0.8rem;
        }
        
        /* Product Cards */
        .product-card {
            height: 100%;
            transition: transform 0.3s;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .product-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        /* Category Cards */
        .category-card {
            height: 100%;
            transition: transform 0.3s;
        }
        
        .category-card:hover {
            transform: translateY(-5px);
        }
        
        /* Price */
        .price-original {
            text-decoration: line-through;
            color: var(--secondary-color);
            font-size: 0.9rem;
        }
        
        .price-discount {
            color: var(--danger-color);
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        /* Badge */
        .badge-discount {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--danger-color);
            color: white;
            font-weight: bold;
            padding: 0.5rem;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Comments */
        .comment {
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 0;
        }
        
        .comment:last-child {
            border-bottom: none;
        }
        
        .comment-user {
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .comment-date {
            font-size: 0.8rem;
            color: var(--secondary-color);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>">
                <i class="bi bi-shop me-2"></i><?= APP_NAME ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $view == 'home' ? 'active' : '' ?>" href="<?= BASE_URL ?>">
                            <i class="bi bi-house-door me-1"></i>Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $view == 'category_list' ? 'active' : '' ?>" href="<?= BASE_URL ?>categories">
                            <i class="bi bi-folder me-1"></i>Danh mục
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $view == 'products' ? 'active' : '' ?>" href="<?= BASE_URL ?>products">
                            <i class="bi bi-box me-1"></i>Sản phẩm
                        </a>
                    </li>
                </ul>
                
                <!-- Search Form -->
                <form class="d-flex me-2" action="<?= BASE_URL ?>product/search" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="search" name="keyword" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" value="<?= $_GET['keyword'] ?? '' ?>">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                
                <!-- User Menu -->
                <ul class="navbar-nav">
                    <?php if (is_logged_in()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i><?= session_get('username') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>profile"><i class="bi bi-person me-2"></i>Hồ sơ</a></li>
                                <?php if (is_admin()): ?>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>admin"><i class="bi bi-speedometer2 me-2"></i>Quản trị</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>logout"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $view == 'login' ? 'active' : '' ?>" href="<?= BASE_URL ?>login">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $view == 'register' ? 'active' : '' ?>" href="<?= BASE_URL ?>register">
                                <i class="bi bi-person-plus me-1"></i>Đăng ký
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content">
        <?php
        if (isset($view)) {
            require_once PATH_VIEW . $view . '.php';
        }
        ?>
    </div>
    
    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-links mb-3">
                        <a href="<?= BASE_URL ?>">Trang chủ</a>
                        <a href="<?= BASE_URL ?>categories">Danh mục</a>
                        <a href="<?= BASE_URL ?>products">Sản phẩm</a>
                        <?php if (!is_logged_in()): ?>
                            <a href="<?= BASE_URL ?>login">Đăng nhập</a>
                            <a href="<?= BASE_URL ?>register">Đăng ký</a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>profile">Hồ sơ</a>
                            <a href="<?= BASE_URL ?>logout">Đăng xuất</a>
                        <?php endif; ?>
                    </div>
                    <p class="mb-0">&copy; <?= date('Y') ?> <?= APP_NAME ?>. Phiên bản <?= APP_VERSION ?>. Bảo lưu mọi quyền.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Hiển thị thông báo toast
        document.addEventListener('DOMContentLoaded', function() {
            // Hiển thị thông báo thành công hoặc lỗi dưới dạng toast
            <?php if (isset($_SESSION['success'])): ?>
                console.log('Thành công: <?= addslashes($_SESSION['success']) ?>');
                showToast('<?= addslashes($_SESSION['success']) ?>', 'success');
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                console.log('Lỗi: <?= addslashes($_SESSION['error']) ?>');
                showToast('<?= addslashes($_SESSION['error']) ?>', 'danger');
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            // Kích hoạt form validation của Bootstrap
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
        
        // Hàm hiển thị toast
        function showToast(message, type) {
            var toastHTML = `
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-${type} text-white">
                            <strong class="me-auto">Thông báo</strong>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            ${message}
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', toastHTML);
            
            // Sử dụng Bootstrap 5 Toast API
            var toastEl = document.querySelector('.toast:last-child');
            var toast = new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 5000
            });
            toast.show();
        }
        
        // Xác nhận xóa
        function confirmDelete(message, url) {
            if (confirm(message)) {
                window.location.href = url;
            }
            return false;
        }
    </script>
</body>
</html>