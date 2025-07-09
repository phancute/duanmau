<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Đăng nhập</h3>
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
                    
                    <form action="<?= BASE_URL ?>login" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $_POST['username'] ?? '' ?>" required>
                            <div class="invalid-feedback">Vui lòng nhập tên đăng nhập</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="invalid-feedback">Vui lòng nhập mật khẩu</div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Chưa có tài khoản? <a href="<?= BASE_URL ?>register">Đăng ký ngay</a></p>
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
                } else {
                    // Log khi form hợp lệ và sẽ được gửi
                    console.log('Form đăng nhập hợp lệ, đang gửi dữ liệu...');
                }
                
                form.classList.add('was-validated');
            }, false);
        });
    })();
    
    // Kiểm tra thông báo thành công/lỗi
    document.addEventListener('DOMContentLoaded', function() {
        // Hiển thị thông báo nếu có
        var successAlert = document.querySelector('.alert-success');
        var errorAlert = document.querySelector('.alert-danger');
        
        if (successAlert) {
            console.log('Thông báo thành công: ' + successAlert.textContent.trim());
        }
        
        if (errorAlert) {
            console.log('Thông báo lỗi: ' + errorAlert.textContent.trim());
        }
    });
</script>