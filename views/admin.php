<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Trang quản trị' ?> - Hệ thống quản lý</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <!-- SheetJS (Excel Export) -->
    <script src="https://cdn.sheetjs.com/xlsx-0.19.3/package/dist/xlsx.full.min.js"></script>
    <!-- Custom styles -->
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
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 10%, #224abe 100%);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: all 0.3s;
        }
        
        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            z-index: 1;
        }
        
        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 0 1rem 1rem;
        }
        
        .sidebar-heading {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0 1rem;
            text-transform: uppercase;
            letter-spacing: 0.13rem;
        }
        
        .nav-item {
            position: relative;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            font-weight: 700;
            font-size: 0.85rem;
        }
        
        .nav-link:hover {
            color: white;
        }
        
        .nav-link.active {
            color: white;
            font-weight: 700;
        }
        
        .nav-link i {
            margin-right: 0.5rem;
            font-size: 0.85rem;
        }
        
        /* Content */
        .content {
            margin-left: 250px;
            padding: 0;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        /* Topbar */
        .topbar {
            height: 70px;
            background-color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .topbar .dropdown-menu {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .topbar .dropdown-list {
            padding: 0;
            border: none;
            overflow: hidden;
        }
        
        .topbar .dropdown-list .dropdown-header {
            background-color: var(--primary-color);
            border: 1px solid var(--primary-color);
            color: white;
        }
        
        .topbar .dropdown-list .dropdown-item {
            white-space: normal;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            border-left: 1px solid #e3e6f0;
            border-right: 1px solid #e3e6f0;
            border-bottom: 1px solid #e3e6f0;
        }
        
        /* Cards */
        .card {
            margin-bottom: 24px;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        }
        
        .card .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 700;
        }
        
        .card-header-tabs {
            margin-right: 0;
            margin-bottom: -1px;
            margin-left: 0;
        }
        
        .card-header-tabs .nav-item.show .nav-link, 
        .card-header-tabs .nav-link.active {
            background-color: #fff;
            border-bottom-color: #fff;
        }
        
        /* Buttons */
        .btn-circle {
            border-radius: 100%;
            height: 2.5rem;
            width: 2.5rem;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-circle.btn-sm {
            height: 1.8rem;
            width: 1.8rem;
            font-size: 0.75rem;
        }
        
        .btn-circle.btn-lg {
            height: 3.5rem;
            width: 3.5rem;
            font-size: 1.35rem;
        }
        
        /* Sidebar Toggle */
        #sidebarToggle {
            width: 2.5rem;
            height: 2.5rem;
            text-align: center;
            margin-bottom: 1rem;
            cursor: pointer;
        }
        
        #sidebarToggle::after {
            font-weight: 900;
            content: '\f104';
            font-family: 'Font Awesome 5 Free';
            margin-right: 0.1rem;
        }
        
        .sidebar.toggled {
            width: 0 !important;
            overflow: hidden;
        }
        
        .sidebar.toggled #sidebarToggle::after {
            content: '\f105';
            font-family: 'Font Awesome 5 Free';
            margin-left: 0.25rem;
        }
        
        .content.toggled {
            margin-left: 0 !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
            }
            
            .content {
                margin-left: 0;
            }
            
            .sidebar.toggled {
                width: 250px !important;
            }
            
            .content.toggled {
                margin-left: 250px !important;
            }
        }
        
        /* Footer */
        footer.sticky-footer {
            padding: 2rem 0;
            flex-shrink: 0;
        }
        
        footer.sticky-footer .copyright {
            line-height: 1;
            font-size: 0.8rem;
        }
        
        /* Dashboard cards */
        .border-left-primary {
            border-left: 0.25rem solid var(--primary-color) !important;
        }
        
        .border-left-success {
            border-left: 0.25rem solid var(--success-color) !important;
        }
        
        .border-left-info {
            border-left: 0.25rem solid var(--info-color) !important;
        }
        
        .border-left-warning {
            border-left: 0.25rem solid var(--warning-color) !important;
        }
        
        .border-left-danger {
            border-left: 0.25rem solid var(--danger-color) !important;
        }
    </style>
</head>
<body>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            <div class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="bi bi-shop"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin</div>
            </div>
            
            <hr class="sidebar-divider my-0">
            
            <li class="nav-item <?= $view == 'admin/dashboard' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= BASE_URL ?>/admin">
                    <i class="bi bi-speedometer2"></i>
                    <span>Bảng điều khiển</span>
                </a>
            </li>
            
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">Quản lý</div>
            
            <li class="nav-item <?= $view == 'admin/categories' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/categories">
                    <i class="bi bi-folder"></i>
                    <span>Danh mục</span>
                </a>
            </li>
            
            <li class="nav-item <?= $view == 'admin/products' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/products">
                    <i class="bi bi-box"></i>
                    <span>Sản phẩm</span>
                </a>
            </li>
            
            <li class="nav-item <?= $view == 'admin/comments' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/comments">
                    <i class="bi bi-chat-dots"></i>
                    <span>Bình luận</span>
                </a>
            </li>
            
            <li class="nav-item <?= $view == 'admin/users' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/users">
                    <i class="bi bi-people"></i>
                    <span>Người dùng</span>
                </a>
            </li>
            
            <hr class="sidebar-divider">
            
            <div class="sidebar-heading">Báo cáo</div>
            
            <li class="nav-item <?= $view == 'admin/reports' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= BASE_URL ?>/admin/reports">
                    <i class="bi bi-bar-chart"></i>
                    <span>Báo cáo & Thống kê</span>
                </a>
            </li>
            
            <hr class="sidebar-divider d-none d-md-block">
            
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column content">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="bi bi-list"></i>
                    </button>
                    
                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['username'] ?? 'Admin' ?></span>
                                <i class="bi bi-person-circle"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= BASE_URL ?>profile">
                                    <i class="bi bi-person fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Hồ sơ
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= BASE_URL ?>">
                                    <i class="bi bi-house fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Về trang chủ
                                </a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>logout">
                                    <i class="bi bi-box-arrow-right fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                    if (isset($view)) {
                        require_once PATH_VIEW . $view . '.php';
                    }
                    ?>
                </div>
                <!-- End of Page Content -->
            </div>
            <!-- End of Main Content -->
            
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <?= APP_NAME ?> <?= date('Y') ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="bi bi-arrow-up"></i>
    </a>
    
    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- DataTables Vietnamese Language -->
    <script src="<?= BASE_URL ?>assets/js/datatables-vietnamese.js"></script>
    
    <!-- Custom scripts -->
    <script>
        // Toggle the side navigation
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.body.querySelector('#sidebarToggle');
            const sidebarToggleTop = document.body.querySelector('#sidebarToggleTop');
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('toggled');
                    content.classList.toggle('toggled');
                });
            }
            
            if (sidebarToggleTop) {
                sidebarToggleTop.addEventListener('click', function(e) {
                    e.preventDefault();
                    sidebar.classList.toggle('toggled');
                    content.classList.toggle('toggled');
                });
            }
            
            // Close any open menu accordions when window is resized below 768px
            window.addEventListener('resize', function() {
                if (window.innerWidth < 768) {
                    sidebar.classList.add('toggled');
                    content.classList.add('toggled');
                } else {
                    sidebar.classList.remove('toggled');
                    content.classList.remove('toggled');
                }
            });
        });
        
        // Hiển thị thông báo từ session nếu có
        <?php if (isset($_SESSION['success'])): ?>
            alert('<?= $_SESSION['success'] ?>');
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            alert('<?= $_SESSION['error'] ?>');
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
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