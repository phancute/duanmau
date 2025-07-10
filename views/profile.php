<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thông tin tài khoản</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="https://via.placeholder.com/150" alt="Avatar" class="rounded-circle img-thumbnail" width="150">
                        <h4 class="mt-3"><?= $user['username'] ?></h4>
                        <p class="text-muted"><?= $user['email'] ?></p>
                        <p>
                            <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'success' ?>">
                                <?= $user['role'] === 'admin' ? 'Quản trị viên' : 'Thành viên' ?>
                            </span>
                        </p>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Ngày tham gia
                            <span><?= date('d/m/Y', strtotime($user['created_at'])) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Số bình luận
                            <span class="badge bg-primary rounded-pill"><?= count($comments) ?></span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2">
                        <a href="<?= BASE_URL ?>change-password" class="btn btn-outline-primary">Đổi mật khẩu</a>
                        <a href="<?= BASE_URL ?>logout" class="btn btn-outline-danger">Đăng xuất</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Bình luận của bạn</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error']; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['success']; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (empty($comments)): ?>
                        <div class="alert alert-info">
                            Bạn chưa có bình luận nào.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Nội dung</th>
                                        <th>Ngày bình luận</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($comments as $comment): ?>
                                        <tr>
                                            <td>
                                                <a href="<?= BASE_URL ?>product/detail/<?= $comment['product_id'] ?>">
                                                    <?= $comment['product_name'] ?>
                                                </a>
                                            </td>
                                            <td><?= $comment['content'] ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></td>
                                            <td>
                                                <?php if ($comment['status'] == 1): ?>
                                                    <span class="badge bg-success">Đã duyệt</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Chờ duyệt</span>
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
    </div>
</div>