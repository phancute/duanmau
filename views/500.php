<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="error-template">
                <h1 class="display-1">500</h1>
                <h2>Lỗi hệ thống</h2>
                <div class="error-details mb-4">
                    Xin lỗi, đã xảy ra lỗi trong quá trình xử lý yêu cầu của bạn!
                </div>
                <div class="error-actions">
                    <a href="<?= BASE_URL ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-house"></i> Về trang chủ
                    </a>
                    <button onclick="window.location.reload()" class="btn btn-outline-secondary btn-lg ms-2">
                        <i class="bi bi-arrow-clockwise"></i> Thử lại
                    </button>
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