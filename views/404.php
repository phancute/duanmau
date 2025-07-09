<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="error-template">
                <h1 class="display-1">404</h1>
                <h2>Không tìm thấy trang</h2>
                <div class="error-details mb-4">
                    Xin lỗi, trang bạn yêu cầu không tồn tại hoặc đã bị di chuyển!
                </div>
                <div class="error-actions">
                    <a href="<?= BASE_URL ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-house"></i> Về trang chủ
                    </a>
                    <a href="<?= BASE_URL ?>categories" class="btn btn-outline-secondary btn-lg ms-2">
                        <i class="bi bi-folder"></i> Xem danh mục sản phẩm
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .error-template {
        padding: 40px 15px;
    }
    
    .error-template h1 {
        font-size: 8rem;
        color: #dc3545;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .error-template h2 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }
    
    .error-details {
        font-size: 1.2rem;
        color: #6c757d;
    }
    
    .error-actions {
        margin-top: 30px;
    }
</style>