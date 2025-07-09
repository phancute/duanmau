<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý danh mục</h1>
        <a href="<?= BASE_URL ?>admin/category/add" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm danh mục mới
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
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách danh mục</h6>
        </div>
        <div class="card-body">
            <?php if (empty($categories)): ?>
                <div class="alert alert-info">
                    Chưa có danh mục nào. Hãy thêm danh mục mới.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="20%">Tên danh mục</th>
                                <th width="55%">Mô tả</th>
                                <th width="10%">Số sản phẩm</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= $category['id'] ?></td>
                                    <td><?= $category['name'] ?></td>
                                    <td><?= $category['description'] ?></td>
                                    <td class="text-center"><?= $category['product_count'] ?? 0 ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= BASE_URL ?>admin/category/edit/<?= $category['id'] ?>" class="btn btn-sm btn-primary" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Xóa" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal<?= $category['id'] ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Modal xác nhận xóa -->
                                        <div class="modal fade" id="deleteModal<?= $category['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $category['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?= $category['id'] ?>">Xác nhận xóa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Bạn có chắc chắn muốn xóa danh mục <strong><?= $category['name'] ?></strong> không?
                                                        <?php if (isset($category['product_count']) && $category['product_count'] > 0): ?>
                                                            <div class="alert alert-warning mt-2">
                                                                <i class="bi bi-exclamation-triangle"></i> Danh mục này đang có <?= $category['product_count'] ?> sản phẩm. 
                                                                Nếu xóa, tất cả sản phẩm trong danh mục này sẽ không có danh mục.
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                        <a href="<?= BASE_URL ?>admin/category/delete/<?= $category['id'] ?>" class="btn btn-danger">Xóa</a>
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
    $(document).ready(function() {
        $('#dataTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Vietnamese.json'
            }
        });
    });
</script>