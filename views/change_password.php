<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Đổi mật khẩu</h3>
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
                    
                    <form action="<?= BASE_URL ?>user/change-password" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <div class="invalid-feedback">Vui lòng nhập mật khẩu hiện tại</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <div class="invalid-feedback">Vui lòng nhập mật khẩu mới</div>
                            <small class="text-muted">Mật khẩu phải có ít nhất 6 ký tự</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <div class="invalid-feedback">Vui lòng xác nhận mật khẩu mới</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                            <a href="<?= BASE_URL ?>user/profile" class="btn btn-outline-secondary">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Validate form
    (function() {
        'use strict';
        
        var forms = document.querySelectorAll('.needs-validation');
        
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                // Kiểm tra mật khẩu và xác nhận mật khẩu
                var newPassword = document.getElementById('new_password');
                var confirmPassword = document.getElementById('confirm_password');
                
                if (newPassword.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Mật khẩu không khớp');
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    confirmPassword.setCustomValidity('');
                }
                
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>