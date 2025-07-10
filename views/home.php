<div class="container">
    <!-- Hero Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner rounded shadow">
                    <div class="carousel-item active">
                        <img src="<?= BASE_URL ?>assets/images/banner1.jpg.svg" class="d-block w-100" alt="Banner 1" style="height: 400px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Chào mừng đến với <?= APP_NAME ?></h2>
                            <p>Khám phá các sản phẩm chất lượng cao với giá cả phải chăng</p>
                            <a href="<?= BASE_URL ?>products" class="btn btn-primary">Xem sản phẩm</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= BASE_URL ?>assets/images/banner2.jpg.svg" class="d-block w-100" alt="Banner 2" style="height: 400px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Khuyến mãi đặc biệt</h2>
                            <p>Giảm giá lên đến 50% cho các sản phẩm mới</p>
                            <a href="<?= BASE_URL ?>products" class="btn btn-primary">Mua ngay</a>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="<?= BASE_URL ?>assets/images/banner3.jpg.svg" class="d-block w-100" alt="Banner 3" style="height: 400px; object-fit: cover;">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Sản phẩm mới</h2>
                            <p>Khám phá các sản phẩm mới nhất của chúng tôi</p>
                            <a href="<?= BASE_URL ?>products" class="btn btn-primary">Xem ngay</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Featured Categories -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-folder me-2"></i>Danh mục sản phẩm</h4>
                    <a href="<?= BASE_URL ?>categories" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if (isset($categories) && count($categories) > 0): ?>
                            <?php foreach ($categories as $category): ?>
                                <div class="col-md-3 col-sm-6 mb-4">
                                    <div class="card category-card h-100">
                                        <img src="<?= BASE_URL . $category['image'] ?>" class="card-img-top" alt="<?= $category['name'] ?>" style="height: 150px; object-fit: cover;">
                                        <div class="card-body text-center">
                                            <h5 class="card-title"><?= $category['name'] ?></h5>
                                            <p class="card-text small text-muted"><?= $category['product_count'] ?? 0 ?> sản phẩm</p>
                                            <a href="<?= BASE_URL ?>categories/detail/<?= $category['id'] ?>" class="btn btn-sm btn-primary">Xem sản phẩm</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-6 col-md-3">
                                <div class="card category-card h-100">
                                    <img src="<?= BASE_URL ?>assets/images/category1.jpg.svg" class="card-img-top" alt="Điện thoại" style="height: 150px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Điện thoại</h5>
                                        <p class="card-text small text-muted">24 sản phẩm</p>
                                        <a href="<?= BASE_URL ?>categories/detail/1" class="btn btn-sm btn-primary">Xem sản phẩm</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card category-card h-100">
                                    <img src="<?= BASE_URL ?>assets/images/category2.jpg.svg" class="card-img-top" alt="Laptop" style="height: 150px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Laptop</h5>
                                        <p class="card-text small text-muted">18 sản phẩm</p>
                                        <a href="<?= BASE_URL ?>categories/detail/2" class="btn btn-sm btn-primary">Xem sản phẩm</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card category-card h-100">
                                    <img src="<?= BASE_URL ?>assets/images/category3.jpg.svg" class="card-img-top" alt="Máy tính bảng" style="height: 150px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Máy tính bảng</h5>
                                        <p class="card-text small text-muted">12 sản phẩm</p>
                                        <a href="<?= BASE_URL ?>categories/detail/3" class="btn btn-sm btn-primary">Xem sản phẩm</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="card category-card h-100">
                                    <img src="<?= BASE_URL ?>assets/images/category4.jpg.svg" class="card-img-top" alt="Phụ kiện" style="height: 150px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Phụ kiện</h5>
                                        <p class="card-text small text-muted">36 sản phẩm</p>
                                        <a href="<?= BASE_URL ?>categories/detail/4" class="btn btn-sm btn-primary">Xem sản phẩm</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-star me-2"></i>Sản phẩm nổi bật</h4>
                    <a href="<?= BASE_URL ?>products" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if (isset($featured_products) && count($featured_products) > 0): ?>
                            <?php foreach ($featured_products as $product): ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card product-card h-100">
                                        <?php if (isset($product['discount']) && $product['discount'] > 0): ?>
                                            <div class="badge-discount">-<?= $product['discount'] ?>%</div>
                                        <?php endif; ?>
                                        <img src="<?= BASE_URL . $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $product['name'] ?></h5>
                                            <p class="card-text small text-muted"><?= $product['category_name'] ?></p>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-<?= $product['status'] ? 'success' : 'danger' ?>">
                                                    <?= $product['status'] ? 'Còn hàng' : 'Hết hàng' ?>
                                                </span>
                                                <span class="text-muted small">SL: <?= $product['stock'] ?></span>
                                            </div>
                                            <?php if (isset($product['discount']) && $product['discount'] > 0): ?>
                                                <p class="card-text mb-0">
                                                    <span class="price-original"><?= format_price($product['price']) ?></span>
                                                </p>
                                                <p class="card-text price-discount">
                                                    <?= format_price($product['price'] * (1 - $product['discount'] / 100)) ?>
                                                </p>
                                            <?php else: ?>
                                                <p class="card-text price-discount">
                                                    <?= format_price($product['price']) ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer bg-white border-top-0">
                                            <a href="<?= BASE_URL ?>product/detail/<?= $product['id'] ?>" class="btn btn-primary w-100">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Product 1 -->
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card product-card h-100">
                                    <div class="badge-discount">Mới</div>
                                    <img src="<?= BASE_URL ?>assets/images/product1.jpg.svg" class="card-img-top" alt="iPhone 13 Pro Max">
                                    <div class="card-body">
                                        <h5 class="card-title">iPhone 13 Pro Max</h5>
                                        <p class="card-text small text-muted">Điện thoại</p>
                                        <p class="card-text price-discount">29.990.000 ₫</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <a href="<?= BASE_URL ?>product/detail/1" class="btn btn-primary w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product 2 -->
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card product-card h-100">
                                    <div class="badge-discount">-10%</div>
                                    <img src="<?= BASE_URL ?>assets/images/product2.jpg.svg" class="card-img-top" alt="Samsung Galaxy S22 Ultra">
                                    <div class="card-body">
                                        <h5 class="card-title">Samsung Galaxy S22 Ultra</h5>
                                        <p class="card-text small text-muted">Điện thoại</p>
                                        <p class="card-text mb-0">
                                            <span class="price-original">28.990.000 ₫</span>
                                        </p>
                                        <p class="card-text price-discount">25.990.000 ₫</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <a href="<?= BASE_URL ?>product/detail/2" class="btn btn-primary w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product 3 -->
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card product-card h-100">
                                    <div class="badge-discount">Hot</div>
                                    <img src="<?= BASE_URL ?>assets/images/product3.jpg.svg" class="card-img-top" alt="MacBook Pro M1">
                                    <div class="card-body">
                                        <h5 class="card-title">MacBook Pro M1</h5>
                                        <p class="card-text small text-muted">Laptop</p>
                                        <p class="card-text price-discount">32.990.000 ₫</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <a href="<?= BASE_URL ?>product/detail/3" class="btn btn-primary w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product 4 -->
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card product-card h-100">
                                    <img src="<?= BASE_URL ?>assets/images/product4.jpg.svg" class="card-img-top" alt="iPad Air 5">
                                    <div class="card-body">
                                        <h5 class="card-title">iPad Air 5</h5>
                                        <p class="card-text small text-muted">Máy tính bảng</p>
                                        <p class="card-text price-discount">16.990.000 ₫</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <a href="<?= BASE_URL ?>product/detail/4" class="btn btn-primary w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Latest Products -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-clock-history me-2"></i>Sản phẩm mới nhất</h4>
                    <a href="<?= BASE_URL ?>products" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php if (isset($latest_products) && count($latest_products) > 0): ?>
                            <?php foreach ($latest_products as $product): ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card product-card h-100">
                                        <?php if (isset($product['discount']) && $product['discount'] > 0): ?>
                                            <div class="badge-discount">-<?= $product['discount'] ?>%</div>
                                        <?php endif; ?>
                                        <img src="<?= BASE_URL . $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $product['name'] ?></h5>
                                            <p class="card-text small text-muted"><?= $product['category_name'] ?></p>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-<?= $product['status'] ? 'success' : 'danger' ?>">
                                                    <?= $product['status'] ? 'Còn hàng' : 'Hết hàng' ?>
                                                </span>
                                                <span class="text-muted small">SL: <?= $product['stock'] ?></span>
                                            </div>
                                            <?php if (isset($product['discount']) && $product['discount'] > 0): ?>
                                                <p class="card-text mb-0">
                                                    <span class="price-original"><?= format_price($product['price']) ?></span>
                                                </p>
                                                <p class="card-text price-discount">
                                                    <?= format_price($product['price'] * (1 - $product['discount'] / 100)) ?>
                                                </p>
                                            <?php else: ?>
                                                <p class="card-text price-discount">
                                                    <?= format_price($product['price']) ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer bg-white border-top-0">
                                            <a href="<?= BASE_URL ?>product/detail/<?= $product['id'] ?>" class="btn btn-primary w-100">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Product 5 -->
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card product-card h-100">
                                    <div class="badge-discount">-15%</div>
                                    <img src="<?= BASE_URL ?>assets/images/product5.jpg.svg" class="card-img-top" alt="Xiaomi 12 Pro">
                                    <div class="card-body">
                                        <h5 class="card-title">Xiaomi 12 Pro</h5>
                                        <p class="card-text small text-muted">Điện thoại</p>
                                        <p class="card-text mb-0">
                                            <span class="price-original">19.990.000 ₫</span>
                                        </p>
                                        <p class="card-text price-discount">16.990.000 ₫</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <a href="<?= BASE_URL ?>product/detail/5" class="btn btn-primary w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product 6 -->
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card product-card h-100">
                                    <img src="<?= BASE_URL ?>assets/images/product6.jpg.svg" class="card-img-top" alt="Dell XPS 13">
                                    <div class="card-body">
                                        <h5 class="card-title">Dell XPS 13</h5>
                                        <p class="card-text small text-muted">Laptop</p>
                                        <p class="card-text price-discount">29.990.000 ₫</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <a href="<?= BASE_URL ?>product/detail/6" class="btn btn-primary w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product 7 -->
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card product-card h-100">
                                    <div class="badge-discount">-8%</div>
                                    <img src="<?= BASE_URL ?>assets/images/product7.jpg.svg" class="card-img-top" alt="Samsung Galaxy Tab S8">
                                    <div class="card-body">
                                        <h5 class="card-title">Samsung Galaxy Tab S8</h5>
                                        <p class="card-text small text-muted">Máy tính bảng</p>
                                        <p class="card-text mb-0">
                                            <span class="price-original">18.990.000 ₫</span>
                                        </p>
                                        <p class="card-text price-discount">17.490.000 ₫</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <a href="<?= BASE_URL ?>product/detail/7" class="btn btn-primary w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Product 8 -->
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="card product-card h-100">
                                    <div class="badge-discount">Mới</div>
                                    <img src="<?= BASE_URL ?>assets/images/product8.jpg.svg" class="card-img-top" alt="Apple Watch Series 7">
                                    <div class="card-body">
                                        <h5 class="card-title">Apple Watch Series 7</h5>
                                        <p class="card-text small text-muted">Phụ kiện</p>
                                        <p class="card-text price-discount">10.990.000 ₫</p>
                                    </div>
                                    <div class="card-footer bg-white border-top-0">
                                        <a href="<?= BASE_URL ?>product/detail/8" class="btn btn-primary w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Features Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 text-center"><i class="bi bi-award me-2"></i>Tại sao chọn chúng tôi?</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="display-4 text-primary mb-3">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <h4>Giao hàng nhanh chóng</h4>
                                    <p class="text-muted">Giao hàng miễn phí cho đơn hàng trên 500.000đ và giao trong ngày tại các thành phố lớn.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="display-4 text-primary mb-3">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <h4>Bảo hành chính hãng</h4>
                                    <p class="text-muted">Tất cả sản phẩm đều được bảo hành chính hãng và có thể đổi trả trong vòng 30 ngày.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="display-4 text-primary mb-3">
                                        <i class="bi bi-headset"></i>
                                    </div>
                                    <h4>Hỗ trợ 24/7</h4>
                                    <p class="text-muted">Đội ngũ tư vấn viên chuyên nghiệp luôn sẵn sàng hỗ trợ bạn mọi lúc mọi nơi.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>