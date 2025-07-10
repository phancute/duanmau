<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Danh mục sản phẩm</li>
        </ol>
    </nav>
    
    <h1 class="mb-4">Danh mục sản phẩm</h1>
    
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
    
    <?php if (empty($categories)): ?>
        <div class="alert alert-info">
            Chưa có danh mục sản phẩm nào.
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($categories as $category): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($category['image'])): ?>
                            <img src="<?= BASE_URL . $category['image'] ?>" class="card-img-top" alt="<?= $category['name'] ?>" style="height: 180px; object-fit: cover;">
                        <?php else: ?>
                            <img src="<?= BASE_URL ?>assets/images/category<?= ($category['id'] % 4) + 1 ?>.jpg.svg" class="card-img-top" alt="<?= $category['name'] ?>" style="height: 180px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?= BASE_URL ?>categories/detail/<?= $category['id'] ?>" class="text-decoration-none">
                                    <?= $category['name'] ?>
                                </a>
                            </h5>
                            <p class="card-text"><?= $category['description'] ?></p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="<?= BASE_URL ?>categories/detail/<?= $category['id'] ?>" class="btn btn-primary btn-sm">
                                Xem sản phẩm
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .card {
        transition: transform 0.3s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .card-title a {
        color: #333;
    }
    
    .card-title a:hover {
        color: #0d6efd;
    }
</style>