<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý bình luận</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Danh sách bình luận</h6>
            <div class="btn-group" role="group">
                <a href="<?= BASE_URL ?>admin/comments" class="btn btn-sm <?= !isset($_GET['status']) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    Tất cả
                </a>
                <a href="<?= BASE_URL ?>admin/comments?status=pending" class="btn btn-sm <?= isset($_GET['status']) && $_GET['status'] === 'pending' ? 'btn-warning' : 'btn-outline-warning' ?>">
                    Chờ duyệt
                </a>
                <a href="<?= BASE_URL ?>admin/comments?status=approved" class="btn btn-sm <?= isset($_GET['status']) && $_GET['status'] === 'approved' ? 'btn-success' : 'btn-outline-success' ?>">
                    Đã duyệt
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($comments)): ?>
                <div class="alert alert-info">
                    Không có bình luận nào.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Người dùng</th>
                                <th width="15%">Sản phẩm</th>
                                <th width="35%">Nội dung</th>
                                <th width="10%">Ngày tạo</th>
                                <th width="10%">Trạng thái</th>
                                <th width="10%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comments as $comment): ?>
                                <tr>
                                    <td><?= $comment['id'] ?></td>
                                    <td><?= $comment['username'] ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>product/detail/<?= $comment['product_id'] ?>" target="_blank">
                                            <?= $comment['product_name'] ?>
                                        </a>
                                    </td>
                                    <td><?= nl2br($comment['content']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></td>
                                    <td class="text-center">
                                        <?php if ($comment['status'] == 1): ?>
                                            <span class="badge bg-success">Đã duyệt</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <?php if ($comment['status'] == 0): ?>
                                                <a href="<?= BASE_URL ?>admin/comment/approve/<?= $comment['id'] ?>" class="btn btn-sm btn-success" title="Duyệt">
                                                    <i class="bi bi-check-lg"></i>
                                                </a>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-sm btn-danger" title="Xóa" 
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal<?= $comment['id'] ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Modal xác nhận xóa -->
                                        <div class="modal fade" id="deleteModal<?= $comment['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $comment['id'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel<?= $comment['id'] ?>">Xác nhận xóa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Bạn có chắc chắn muốn xóa bình luận này không?</p>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <p><strong>Người dùng:</strong> <?= $comment['username'] ?></p>
                                                                <p><strong>Sản phẩm:</strong> <?= $comment['product_name'] ?></p>
                                                                <p><strong>Nội dung:</strong> <?= nl2br($comment['content']) ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                        <a href="<?= BASE_URL ?>admin/comment/delete/<?= $comment['id'] ?>" class="btn btn-danger">Xóa</a>
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