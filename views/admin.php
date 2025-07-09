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
        }
        
        .card-header h6 {
            font-weight: 700;
            font-size: 1rem;
            color: var(--primary-color);
        }
        
        /* Border Left Utilities */
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
        
        /* Charts */
        .chart-area {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        .chart-pie {
            position: relative;
            height: 250px;
            width: 100%;
        }
        
        /* Toggle Sidebar */
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
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-search"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-bell"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">Thông báo</h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="bi bi-chat-dots text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">12/12/2023</div>
                                        <span class="font-weight-bold">Có bình luận mới cần duyệt!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="bi bi-person text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">11/12/2023</div>
                                        Người dùng mới đã đăng ký!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="bi bi-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">10/12/2023</div>
                                        Cảnh báo: Sản phẩm sắp hết hàng!
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Xem tất cả thông báo</a>
                            </div>
                        </li>
                        
                        <div class="topbar-divider d-none d-sm-block"></div>
                        
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['user_name'] ?? 'Admin' ?></span>
                                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Hồ sơ
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-gear fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cài đặt
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-list-check fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Nhật ký hoạt động
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="bi bi-box-arrow-right fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                
                <!-- Begin Page Content -->
                <?php include $view . '.php'; ?>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Hệ thống quản lý 2023</span>
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
        <i class="bi bi-chevron-up"></i>
    </a>
    
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn chắc chắn muốn đăng xuất?</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Chọn "Đăng xuất" bên dưới nếu bạn đã sẵn sàng kết thúc phiên làm việc hiện tại.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="<?= BASE_URL ?>/user/logout">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Custom scripts -->
    <script>
        // Toggle the side navigation
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarToggleTop = document.getElementById('sidebarToggleTop');
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
            
            // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
            const fixedNavigation = document.querySelector('body.fixed-nav .sidebar');
            if (fixedNavigation) {
                fixedNavigation.on('mousewheel DOMMouseScroll wheel', function(e) {
                    if (window.innerWidth > 768) {
                        const e0 = e.originalEvent;
                        const delta = e0.wheelDelta || -e0.detail;
                        this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                        e.preventDefault();
                    }
                });
            }
            
            // Initialize DataTables
            if ($.fn.DataTable) {
                $('.dataTable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/vi.json'
                    }
                });
            }
        });
    </script>
</body>
</html>