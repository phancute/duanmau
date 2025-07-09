<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= isset($category) ? 'Cập nhật danh mục' : 'Thêm danh mục mới' ?></h1>
        <a href="<?= BASE_URL ?>admin/categories" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
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
            <h6 class="m-0 font-weight-bold text-primary"><?= isset($category) ? 'Cập nhật thông tin danh mục' : 'Nhập thông tin danh mục mới' ?></h6>
        </div>
        <div class="card-body">
            <form action="<?= isset($category) ? BASE_URL . 'admin/category/edit/' . $category['id'] : BASE_URL . 'admin/category/add' ?>" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= isset($category) ? $category['name'] : '' ?>" required>
                    <div class="invalid-feedback">Vui lòng nhập tên danh mục</div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="5"><?= isset($category) ? $category['description'] : '' ?></textarea>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-outline-secondary me-md-2">Làm mới</button>
                    <button type="submit" class="btn btn-primary"><?= isset($category) ? 'Cập nhật' : 'Thêm mới' ?></button>
                </div>
            </form>
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
                
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>