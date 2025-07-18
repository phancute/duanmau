<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <?php if (isset($_GET['category']) && isset($category)): ?>
                    Sản phẩm trong danh mục "<?= $category['name'] ?>"
                    <a href="<?= BASE_URL ?>admin/products" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                <?php else: ?>
                    Quản lý sản phẩm
                <?php endif; ?>
            </h1>
        </div>
        <a href="<?= BASE_URL ?>admin/product/add" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm sản phẩm mới
        </a>
    </div>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Lọc theo danh mục
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/products">Tất cả</a></li>
                    <?php foreach ($categories as $category): ?>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>admin/products?category=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($products)): ?>
                <div class="alert alert-info">
                    <?php if (isset($_GET['category'])): ?>
                        Không có sản phẩm nào trong danh mục này. <a href="<?= BASE_URL ?>admin/products">Xem tất cả sản phẩm</a>
                    <?php else: ?>
                        Chưa có sản phẩm nào. Hãy thêm sản phẩm mới.
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="10%">Hình ảnh</th>
                                <th width="20%">Tên sản phẩm</th>
                                <th width="10%">Danh mục</th>
                                <th width="10%">Giá</th>
                                <th width="5%">Giảm giá</th>
                                <th width="5%">Số lượng</th>
                                <th width="5%">Trạng thái</th>
                                <th width="10%">Ngày tạo</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td class="text-center">
                                        <img src="<?= $product['image_url'] ? BASE_URL . 'assets/uploads/' . $product['image_url'] : 'https://via.placeholder.com/80x80' ?>" 
                                             alt="<?= $product['name'] ?>" class="img-thumbnail" width="80">
                                    </td>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= $product['category_name'] ?></td>
                                    <td class="text-end"><?= number_format($product['price'], 0, ',', '.') ?> đ</td>
                                    <td class="text-center">
                                        <?php if (isset($product['discount']) && $product['discount'] > 0): ?>
                                            <span class="badge bg-danger"><?= $product['discount'] ?>%</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">0%</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $product['stock'] ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-<?= $product['status'] ? 'success' : 'danger' ?>">
                                            <?= $product['status'] ? 'Còn hàng' : 'Hết hàng' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($product['created_at'])) ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= BASE_URL ?>product/detail/<?= $product['id'] ?>" class="btn btn-sm btn-info" title="Xem" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= BASE_URL ?>admin/product/edit/<?= $product['id'] ?>" class="btn btn-sm btn-primary" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Xóa" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal<?= $product['id'] ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Modal xác nhận xóa -->
                                        <div class="modal fade" id="deleteModal<?= $product['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $product['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?= $product['id'] ?>">Xác nhận xóa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn muốn xóa sản phẩm <strong><?= $product['name'] ?></strong> không?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                        <a href="<?= BASE_URL ?>admin/product/delete/<?= $product['id'] ?>" class="btn btn-danger">Xóa</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            // Đảm bảo biến vietnameseLanguage đã được định nghĩa trước khi sử dụng
            var checkDataTablesLanguage = setInterval(function() {
                if (typeof vietnameseLanguage !== 'undefined') {
                    clearInterval(checkDataTablesLanguage);
                    $('#dataTable').DataTable({
                        language: vietnameseLanguage,
                        order: [[0, 'desc']]
                    });
                }
            }, 100);
            
            // Đặt thời gian chờ tối đa để tránh vòng lặp vô hạn
            setTimeout(function() {
                clearInterval(checkDataTablesLanguage);
                if (typeof vietnameseLanguage === 'undefined') {
                    console.error('Vietnamese language file not loaded. Using default language.');
                    $('#dataTable').DataTable({
                        order: [[0, 'desc']]
                    });
                }
            }, 3000);
        } else {
            console.error('jQuery is not loaded. DataTable initialization failed.');
        }
    });
</script>