<?php
// Hàm lấy màu cho biểu đồ
function getChartColor($index) {
    $colors = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
        '#5a5c69', '#6f42c1', '#fd7e14', '#20c997', '#6c757d'
    ];
    return $colors[$index % count($colors)];
}
?>

<div class="container-fluid py-4">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Bảng điều khiển</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="bi bi-download fa-sm text-white-50"></i> Tạo báo cáo
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Tổng sản phẩm -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalProducts ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng danh mục -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Danh mục</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $totalCategories ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-folder fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng người dùng -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Người dùng</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $totalUsers ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng bình luận -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Bình luận</div>
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

    <!-- Content Row -->
    <div class="row">
        <!-- Biểu đồ người dùng đăng ký -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Người dùng đăng ký</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Tùy chọn:</div>
                            <a class="dropdown-item" href="#">Tháng này</a>
                            <a class="dropdown-item" href="#">Quý này</a>
                            <a class="dropdown-item" href="#">Năm nay</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="userRegistrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ sản phẩm theo danh mục -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Sản phẩm theo danh mục</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Tùy chọn:</div>
                            <a class="dropdown-item" href="#">Xem chi tiết</a>
                            <a class="dropdown-item" href="#">Xuất báo cáo</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
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
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Sản phẩm mới nhất -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sản phẩm mới nhất</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Danh mục</th>
                                    <th>Giá</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latestProducts as $product): ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= $product['category_name'] ?></td>
                                    <td><?= number_format($product['price'], 0, ',', '.') ?> đ</td>
                                    <td><?= date('d/m/Y', strtotime($product['created_at'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bình luận mới nhất -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bình luận mới nhất</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Người dùng</th>
                                    <th>Sản phẩm</th>
                                    <th>Nội dung</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latestComments as $comment): ?>
                                <tr>
                                    <td><?= $comment['username'] ?></td>
                                    <td><?= $comment['product_name'] ?></td>
                                    <td><?= substr($comment['content'], 0, 30) . (strlen($comment['content']) > 30 ? '...' : '') ?></td>
                                    <td><?= date('d/m/Y', strtotime($comment['created_at'])) ?></td>
                                    <td>
                                        <?php if ($comment['approved'] == 1): ?>
                                            <span class="badge bg-success">Đã duyệt</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Chờ duyệt</span>
                                        <?php endif; ?>
                                    </td>
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
    
    // Biểu đồ người dùng đăng ký
    document.addEventListener('DOMContentLoaded', function() {
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
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            beginAtZero: true
                        },
                        gridLines: {
                            color: 'rgb(234, 236, 244)',
                            zeroLineColor: 'rgb(234, 236, 244)',
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
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
        
        // Biểu đồ sản phẩm theo danh mục
        const categoryData = <?= json_encode($productsByCategory) ?>;
        const categoryLabels = categoryData.map(item => item.name);
        const categoryValues = categoryData.map(item => item.count);
        const categoryColors = categoryData.map((_, index) => getChartColor(index));
        
        const ctxPie = document.getElementById('productsByCategoryChart').getContext('2d');
        const productsByCategoryChart = new Chart(ctxPie, {
            type: 'doughnut',
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
                tooltips: {
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
                cutoutPercentage: 80,
            },
        });
    });
</script>