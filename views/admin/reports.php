<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Báo cáo và thống kê</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary" onclick="window.print()">
                <i class="bi bi-printer"></i> In báo cáo
            </button>
            <button type="button" class="btn btn-outline-success" id="exportBtn">
                <i class="bi bi-file-earmark-excel"></i> Xuất Excel
            </button>
        </div>
    </div>
    
    <!-- Thống kê tổng quan -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalProducts ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tổng danh mục</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalCategories ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-folder fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng người dùng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalUsers ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tổng bình luận</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalComments ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-chat-dots fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Biểu đồ sản phẩm theo danh mục -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Sản phẩm theo danh mục</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="productsByCategoryChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <?php foreach ($productsByCategory as $index => $category): ?>
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color: <?= getChartColor($index) ?>"></i> <?= $category['name'] ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Biểu đồ người dùng đăng ký theo tháng -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Người dùng đăng ký theo tháng</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="userRegistrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Bảng thống kê sản phẩm theo danh mục -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê sản phẩm theo danh mục</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="categoryTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Danh mục</th>
                                    <th>Số sản phẩm</th>
                                    <th>Tỷ lệ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productsByCategory as $category): ?>
                                    <tr>
                                        <td><?= $category['name'] ?></td>
                                        <td><?= $category['count'] ?></td>
                                        <td>
                                            <?php $percent = ($totalProducts > 0) ? round(($category['count'] / $totalProducts) * 100, 2) : 0; ?>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: <?= $percent ?>%" 
                                                     aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100">
                                                    <?= $percent ?>%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bảng thống kê bình luận theo tháng -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê bình luận theo tháng</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="commentTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tháng</th>
                                    <th>Số bình luận</th>
                                    <th>Đã duyệt</th>
                                    <th>Chờ duyệt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($commentStats as $stat): ?>
                                    <tr>
                                        <td><?= $stat['month'] ?>/<?= $stat['year'] ?></td>
                                        <td><?= $stat['total'] ?></td>
                                        <td><?= $stat['approved'] ?></td>
                                        <td><?= $stat['pending'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Hàm lấy màu cho biểu đồ
    function getChartColor(index) {
        const colors = [
            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
            '#5a5c69', '#6f42c1', '#fd7e14', '#20c997', '#6c757d'
        ];
        return colors[index % colors.length];
    }
    
    // Biểu đồ sản phẩm theo danh mục
    document.addEventListener('DOMContentLoaded', function() {
        const categoryData = <?= json_encode($productsByCategory) ?>;
        const categoryLabels = categoryData.map(item => item.name);
        const categoryValues = categoryData.map(item => item.count);
        const categoryColors = categoryData.map((_, index) => getChartColor(index));
        
        const ctxPie = document.getElementById('productsByCategoryChart').getContext('2d');
        const productsByCategoryChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryValues,
                    backgroundColor: categoryColors,
                    hoverBackgroundColor: categoryColors,
                    hoverBorderColor: 'rgba(234, 236, 244, 1)',
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        backgroundColor: 'rgb(255,255,255)',
                        bodyFontColor: '#858796',
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                },
                cutout: '0%',
            },
        });
        
        // Biểu đồ người dùng đăng ký theo tháng
        const registrationData = <?= json_encode($userRegistrationStats) ?>;
        const months = registrationData.map(item => item.month + '/' + item.year);
        const registrations = registrationData.map(item => item.count);
        
        const ctxArea = document.getElementById('userRegistrationChart').getContext('2d');
        const userRegistrationChart = new Chart(ctxArea, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Người dùng đăng ký',
                    lineTension: 0.3,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    pointRadius: 3,
                    pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                    pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: registrations,
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    x: {
                        time: {
                            unit: 'month'
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    },
                    y: {
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            beginAtZero: true
                        },
                        grid: {
                            color: 'rgb(234, 236, 244)',
                            drawBorder: false,
                            borderDash: [2],
                            borderDash: [2]
                        }
                    },
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                    backgroundColor: 'rgb(255,255,255)',
                    bodyFontColor: '#858796',
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10
                }
            }
        });
    });
    
    // Xuất Excel
    document.getElementById('exportBtn').addEventListener('click', function() {
        // Tạo workbook mới
        const wb = XLSX.utils.book_new();
        
        // Thêm worksheet cho sản phẩm theo danh mục
        const categoryTable = document.getElementById('categoryTable');
        const categoryWs = XLSX.utils.table_to_sheet(categoryTable);
        XLSX.utils.book_append_sheet(wb, categoryWs, 'Sản phẩm theo danh mục');
        
        // Thêm worksheet cho bình luận theo tháng
        const commentTable = document.getElementById('commentTable');
        const commentWs = XLSX.utils.table_to_sheet(commentTable);
        XLSX.utils.book_append_sheet(wb, commentWs, 'Bình luận theo tháng');
        
        // Xuất file Excel
        XLSX.writeFile(wb, 'bao-cao-thong-ke.xlsx');
    });
</script>

<style>
    @media print {
        .btn-group, .sidebar, .topbar, footer {
            display: none !important;
        }
        
        .container-fluid {
            width: 100% !important;
            padding: 0 !important;
        }
        
        .card {
            break-inside: avoid;
        }
    }
</style>