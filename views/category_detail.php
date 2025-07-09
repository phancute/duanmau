<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>category">Danh mục sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $category['name'] ?></li>
        </ol>
    </nav>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title"><?= $category['name'] ?></h1>
                    <p class="card-text"><?= $category['description'] ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <h2 class="mb-4">Sản phẩm trong danh mục</h2>
    
    <?php if (empty($products)): ?>
        <div class="alert alert-info">
            Chưa có sản phẩm nào trong danh mục này.
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm product-card">
                        <img src="<?= $product['image'] ? BASE_URL . 'uploads/' . $product['image'] : 'https://via.placeholder.com/300x200' ?>" 
                             class="card-img-top" alt="<?= $product['name'] ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?= BASE_URL ?>product/detail/<?= $product['id'] ?>" class="text-decoration-none">
                                    <?= $product['name'] ?>
                                </a>
                            </h5>
                            <p class="card-text text-truncate"><?= $product['description'] ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-danger fw-bold"><?= number_format($product['price'], 0, ',', '.') ?> đ</span>
                                <?php if ($product['discount'] > 0): ?>
                                    <span class="badge bg-danger">-<?= $product['discount'] ?>%</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-grid">
                                <a href="<?= BASE_URL ?>product/detail/<?= $product['id'] ?>" class="btn btn-primary btn-sm">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Phân trang -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= BASE_URL ?>category/detail/<?= $category['id'] ?>/<?= $currentPage - 1 ?>">
                                &laquo; Trước
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="<?= BASE_URL ?>category/detail/<?= $category['id'] ?>/<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= BASE_URL ?>category/detail/<?= $category['id'] ?>/<?= $currentPage + 1 ?>">
                                Tiếp &raquo;
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
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