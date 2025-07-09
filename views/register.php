<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Đăng ký tài khoản</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Kiểm tra kết nối cơ sở dữ liệu
                    try {
                        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);
                        $testPdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
                        echo '<script>console.log("Kết nối cơ sở dữ liệu thành công với: ' . addslashes($dsn) . '");</script>';
                        
                        // Kiểm tra bảng users
                        $checkTable = $testPdo->query("SHOW TABLES LIKE 'users'");
                        if ($checkTable->rowCount() > 0) {
                            echo '<script>console.log("Bảng users tồn tại");</script>';
                        } else {
                            echo '<script>console.log("Bảng users không tồn tại");</script>';
                        }
                    } catch (PDOException $e) {
                        echo '<script>console.log("Lỗi kết nối cơ sở dữ liệu: ' . addslashes($e->getMessage()) . '");</script>';
                    }
                    ?>
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
                    
                    <form action="<?= BASE_URL ?>register" method="POST" class="needs-validation" novalidate>
                        <!-- Thêm CSRF token -->
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $_POST['username'] ?? '' ?>" required>
                            <div class="invalid-feedback">Vui lòng nhập tên đăng nhập</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>
                            <div class="invalid-feedback">Vui lòng nhập email hợp lệ</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="invalid-feedback">Vui lòng nhập mật khẩu</div>
                            <small class="text-muted">Mật khẩu phải có ít nhất 6 ký tự</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <div class="invalid-feedback">Vui lòng xác nhận mật khẩu</div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Đăng ký</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">Đã có tài khoản? <a href="<?= BASE_URL ?>login">Đăng nhập ngay</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Kiểm tra kết nối cơ sở dữ liệu khi trang được tải
    console.log('Trang đăng ký đã được tải, kiểm tra kết nối cơ sở dữ liệu...');
    
    // Validate form
    (function() {
        'use strict';
        
        var forms = document.querySelectorAll('.needs-validation');
        
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    console.log('Form không hợp lệ, vui lòng kiểm tra lại các trường');
                } else {
                    // Log khi form hợp lệ và sẽ được gửi
                    console.log('Form đăng ký hợp lệ, đang gửi dữ liệu...');
                    
                    // Thêm debug để kiểm tra dữ liệu form
                    console.log('Dữ liệu đăng ký:', {
                        username: document.getElementById('username').value,
                        email: document.getElementById('email').value,
                        password: '******' // Không hiển thị mật khẩu thực tế
                    });
                    
                    // Thêm thông báo để theo dõi quá trình gửi form
                    console.log('Đang gửi form đăng ký...');
                }
                
                // Kiểm tra mật khẩu và xác nhận mật khẩu
                var password = document.getElementById('password');
                var confirmPassword = document.getElementById('confirm_password');
                
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Mật khẩu không khớp');
                    event.preventDefault();
                    event.stopPropagation();
                    console.log('Mật khẩu không khớp');
                } else {
                    confirmPassword.setCustomValidity('');
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