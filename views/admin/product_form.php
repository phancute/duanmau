<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= isset($product['id']) ? 'Cập nhật sản phẩm' : 'Thêm sản phẩm mới' ?></h1>
        <a href="<?= BASE_URL ?>admin/products" class="btn btn-secondary">
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
            <h6 class="m-0 font-weight-bold text-primary"><?= isset($product['id']) ? 'Cập nhật thông tin sản phẩm' : 'Nhập thông tin sản phẩm mới' ?></h6>
        </div>
        <div class="card-body">
            <form action="<?= $formAction ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $product['name'] ?>" required>
                            <div class="invalid-feedback">Vui lòng nhập tên sản phẩm</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                        <?= $category['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Vui lòng chọn danh mục</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="price" name="price" 
                                               value="<?= $product['price'] ?>" min="0" required>
                                        <span class="input-group-text">đ</span>
                                    </div>
                                    <div class="invalid-feedback">Vui lòng nhập giá sản phẩm</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Giảm giá (%)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="discount" name="discount" 
                                               value="<?= isset($product['discount']) ? $product['discount'] : 0 ?>" min="0" max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stock" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" id="stock" name="stock" 
                                   value="<?= $product['stock'] ?>" min="0">
                        </div>
                        
                        <div class="mb-3">
                            <label for="specifications" class="form-label">Thông số kỹ thuật</label>
                            <textarea class="form-control" id="specifications" name="specifications" rows="3"><?= $product['specifications'] ?></textarea>
                            <div class="form-text">Nhập các thông số kỹ thuật của sản phẩm, mỗi thông số trên một dòng</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả sản phẩm <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="5" required><?= $product['description'] ?></textarea>
                            <div class="invalid-feedback">Vui lòng nhập mô tả sản phẩm</div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh sản phẩm <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" <?= !isset($product['id']) ? 'required' : '' ?>>
                            <div class="form-text">Chọn file hình ảnh có định dạng: jpg, jpeg, png, gif</div>
                            
                            <?php if (isset($product['id']) && !empty($product['image_url'])): ?>
                                <div class="mt-2">
                                    <p>Hình ảnh hiện tại:</p>
                                    <img src="<?= BASE_URL . 'assets/uploads/' . $product['image_url'] ?>" alt="<?= $product['name'] ?>" class="img-thumbnail" style="max-width: 200px;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                        <label class="form-check-label" for="remove_image">
                                            Xóa hình ảnh
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="1" <?= $product['status'] == 1 ? 'selected' : '' ?>>Còn hàng</option>
                                <option value="0" <?= $product['status'] == 0 ? 'selected' : '' ?>>Hết hàng</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="featured" class="form-label">Sản phẩm nổi bật</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" 
                                       <?= $product['featured'] == 1 ? 'checked' : '' ?>>
                                <label class="form-check-label" for="featured">Hiển thị ở trang chủ</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-outline-secondary me-md-2">Làm mới</button>
                    <button type="submit" class="btn btn-primary"><?= isset($product['id']) ? 'Cập nhật' : 'Thêm mới' ?></button>
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
    
    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const imgElement = document.querySelector('.img-thumbnail');
                if (imgElement) {
                    imgElement.src = event.target.result;
                } else {
                    const newImg = document.createElement('img');
                    newImg.src = event.target.result;
                    newImg.classList.add('img-thumbnail', 'mt-2');
                    newImg.style.maxWidth = '200px';
                    document.querySelector('.form-text').insertAdjacentElement('afterend', newImg);
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>