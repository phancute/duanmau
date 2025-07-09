<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>category/detail/<?= $product['category_id'] ?>"><?= $product['category_name'] ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $product['name'] ?></li>
        </ol>
    </nav>
    
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
    
    <div class="row mb-5">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-5">
            <div class="card shadow-sm">
                <img src="<?= $product['image'] ? BASE_URL . 'uploads/' . $product['image'] : 'https://via.placeholder.com/600x400' ?>" 
                     class="card-img-top" alt="<?= $product['name'] ?>" style="object-fit: cover; height: 400px;">
            </div>
        </div>
        
        <!-- Thông tin sản phẩm -->
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title mb-3"><?= $product['name'] ?></h1>
                    
                    <div class="d-flex align-items-center mb-3">
                        <span class="me-3 fs-4 text-danger fw-bold">
                            <?= number_format($product['price'] * (1 - $product['discount'] / 100), 0, ',', '.') ?> đ
                        </span>
                        
                        <?php if ($product['discount'] > 0): ?>
                            <span class="text-decoration-line-through text-muted me-2">
                                <?= number_format($product['price'], 0, ',', '.') ?> đ
                            </span>
                            <span class="badge bg-danger">-<?= $product['discount'] ?>%</span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge bg-<?= $product['status'] ? 'success' : 'danger' ?>">
                            <?= $product['status'] ? 'Còn hàng' : 'Hết hàng' ?>
                        </span>
                        <span class="ms-2">Danh mục: <a href="<?= BASE_URL ?>category/detail/<?= $product['category_id'] ?>"><?= $product['category_name'] ?></a></span>
                    </div>
                    
                    <hr>
                    
                    <h5>Mô tả sản phẩm</h5>
                    <p class="card-text"><?= nl2br($product['description']) ?></p>
                    
                    <hr>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <button class="btn btn-primary" type="button">
                            <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                        </button>
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="bi bi-heart"></i> Yêu thích
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bình luận -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Bình luận</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <form action="<?= BASE_URL ?>product/add-comment/<?= $product['id'] ?>" method="POST" class="mb-4">
                            <div class="mb-3">
                                <label for="comment" class="form-label">Viết bình luận của bạn</label>
                                <textarea class="form-control" id="comment" name="content" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-info">
                            Vui lòng <a href="<?= BASE_URL ?>login">đăng nhập</a> để bình luận về sản phẩm này.
                        </div>
                    <?php endif; ?>
                    
                    <hr>
                    
                    <h5>Các bình luận (<?= count($comments) ?>)</h5>
                    
                    <?php if (empty($comments)): ?>
                        <div class="alert alert-info">
                            Chưa có bình luận nào cho sản phẩm này.
                        </div>
                    <?php else: ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <i class="bi bi-person-circle"></i> <?= $comment['username'] ?>
                                        </h6>
                                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></small>
                                    </div>
                                    <p class="card-text"><?= nl2br($comment['content']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sản phẩm liên quan -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-4">Sản phẩm liên quan</h3>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <?php foreach ($relatedProducts as $relatedProduct): ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm product-card">
                                <img src="<?= $relatedProduct['image'] ? BASE_URL . 'uploads/' . $relatedProduct['image'] : 'https://via.placeholder.com/300x200' ?>" 
                                     class="card-img-top" alt="<?= $relatedProduct['name'] ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="<?= BASE_URL ?>product/detail/<?= $relatedProduct['id'] ?>" class="text-decoration-none">
                                            <?= $relatedProduct['name'] ?>
                                        </a>
                                    </h5>
                                    <p class="card-text text-truncate"><?= $relatedProduct['description'] ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-danger fw-bold"><?= number_format($relatedProduct['price'], 0, ',', '.') ?> đ</span>
                                        <?php if ($relatedProduct['discount'] > 0): ?>
                                            <span class="badge bg-danger">-<?= $relatedProduct['discount'] ?>%</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-grid">
                                        <a href="<?= BASE_URL ?>product/detail/<?= $relatedProduct['id'] ?>" class="btn btn-primary btn-sm">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .product-card {
        transition: transform 0.3s;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
    }
    
    .card-title a {
        color: #333;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 48px;
    }
    
    .card-title a:hover {
        color: #0d6efd;
    }
</style>