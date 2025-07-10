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
    // Hiển thị thông tin session trong console khi trang đăng nhập được tải
    console.log('Login page loaded');
    console.log('Current session on login page:', <?= json_encode($_SESSION) ?>);
    console.log('Is logged in on login page:', <?= is_logged_in() ? 'true' : 'false' ?>);
    
    // Validate form
    (function() {
        'use strict';
        
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation');
        
        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
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
        
        <?php if (isset($_SESSION['console_log'])): ?>
            // Hiển thị thông báo console với màu nổi bật và kích thước lớn hơn
            console.log('%c THÔNG BÁO: <?= $_SESSION['console_log'] ?>', 'background: #4CAF50; color: white; font-size: 14px; padding: 5px; border-radius: 3px;');
            // Hiển thị thông báo lặp lại 3 lần để đảm bảo người dùng không bỏ lỡ
            setTimeout(function() {
                console.log('%c THÔNG BÁO: <?= $_SESSION['console_log'] ?>', 'background: #4CAF50; color: white; font-size: 14px; padding: 5px; border-radius: 3px;');
            }, 500);
            setTimeout(function() {
                console.log('%c THÔNG BÁO: <?= $_SESSION['console_log'] ?>', 'background: #4CAF50; color: white; font-size: 14px; padding: 5px; border-radius: 3px;');
            }, 1000);
            
            // Hiển thị thông báo alert để đảm bảo người dùng không bỏ lỡ
            alert('<?= $_SESSION['console_log'] ?>');
            <?php unset($_SESSION['console_log']); ?>
        <?php endif; ?>
    });
</script>