<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý người dùng</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
            <div class="btn-group" role="group">
                <a href="<?= BASE_URL ?>admin/users" class="btn btn-sm <?= !isset($_GET['status']) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    Tất cả
                </a>
                <a href="<?= BASE_URL ?>admin/users?status=active" class="btn btn-sm <?= isset($_GET['status']) && $_GET['status'] === 'active' ? 'btn-success' : 'btn-outline-success' ?>">
                    Đang hoạt động
                </a>
                <a href="<?= BASE_URL ?>admin/users?status=inactive" class="btn btn-sm <?= isset($_GET['status']) && $_GET['status'] === 'inactive' ? 'btn-danger' : 'btn-outline-danger' ?>">
                    Đã khóa
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($users)): ?>
                <div class="alert alert-info">
                    Không có người dùng nào.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">Tên đăng nhập</th>
                                <th width="20%">Email</th>
                                <th width="10%">Vai trò</th>
                                <th width="10%">Trạng thái</th>
                                <th width="15%">Ngày đăng ký</th>
                                <th width="10%">Số bình luận</th>
                                <th width="15%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td>
                                        <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?>">
                                            <?= $user['role'] === 'admin' ? 'Quản trị viên' : 'Thành viên' ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-<?= $user['active'] ? 'success' : 'danger' ?>">
                                            <?= $user['active'] ? 'Đang hoạt động' : 'Đã khóa' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                                    <td class="text-center"><?= $user['comment_count'] ?? 0 ?></td>
                                    <td>
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                            <div class="btn-group" role="group">
                                                <?php if ($user['active']): ?>
                                                    <button type="button" class="btn btn-sm btn-warning" title="Khóa tài khoản" 
                                                            data-bs-toggle="modal" data-bs-target="#blockModal<?= $user['id'] ?>">
                                                        <i class="bi bi-lock"></i> Khóa
                                                    </button>
                                                <?php else: ?>
                                                    <button type="button" class="btn btn-sm btn-success" title="Mở khóa tài khoản" 
                                                            data-bs-toggle="modal" data-bs-target="#unblockModal<?= $user['id'] ?>">
                                                        <i class="bi bi-unlock"></i> Mở khóa
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Modal xác nhận khóa tài khoản -->
                                            <?php if ($user['active']): ?>
                                                <div class="modal fade" id="blockModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="blockModalLabel<?= $user['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="blockModalLabel<?= $user['id'] ?>">Xác nhận khóa tài khoản</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Bạn có chắc chắn muốn khóa tài khoản <strong><?= $user['username'] ?></strong> không?</p>
                                                                <p>Người dùng này sẽ không thể đăng nhập vào hệ thống sau khi bị khóa.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                                <a href="<?= BASE_URL ?>admin/user/toggle-status/<?= $user['id'] ?>" class="btn btn-warning">Khóa tài khoản</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <!-- Modal xác nhận mở khóa tài khoản -->
                                                <div class="modal fade" id="unblockModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="unblockModalLabel<?= $user['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="unblockModalLabel<?= $user['id'] ?>">Xác nhận mở khóa tài khoản</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Bạn có chắc chắn muốn mở khóa tài khoản <strong><?= $user['username'] ?></strong> không?</p>
                                                                <p>Người dùng này sẽ có thể đăng nhập vào hệ thống sau khi được mở khóa.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                                <a href="<?= BASE_URL ?>admin/user/toggle-status/<?= $user['id'] ?>" class="btn btn-success">Mở khóa tài khoản</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Tài khoản hiện tại</span>
                                        <?php endif; ?>
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
            },
            order: [[0, 'desc']]
        });
    });
</script>