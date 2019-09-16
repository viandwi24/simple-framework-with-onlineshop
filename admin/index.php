<?php require_once __DIR__ . '/../mod/__load.php'; //load system ?>
<?php if(!auth()->guard('admin')->check()){ redirect(url('admin/login.php')); } //require auth ?>
<?php if (!isset($_GET['page'])) redirect(url('admin?page=home')); ?>
<!doctype html>
<html lang="en">
<head>
    <!-- PageTitle -->
    <title>Admin <?= WEB['title']; ?></title>
    <!-- CSS -->
    <?php Template::get('css'); ?>
</head>
<body>
    <!-- Navbar -->
    <?php Template::get('admin_navbar'); ?>

    <div class="container mb-5 mt-5">
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body p-0 pt-1 pb-1">
                        <div class="nav flex-column nav-pills" aria-orientation="vertical">
                            <a class="nav-link" href="<?= url('admin?page=home'); ?>">Home</a>
                            <a class="nav-link" href="<?= url('admin?page=product'); ?>">Produk</a>
                            <a class="nav-link" href="<?= url('admin?page=transaction'); ?>">Transaksi</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <?php
                if (isset($_GET['page'])) {
                    $page = ['home', 'product', 'transaction'];
                    if (in_array($_GET['page'], $page)) {
                        Template::get('admin_' . $_GET['page']);
                    } else { echo "<h1>404</h1>"; }
                } else { echo "<h1>404</h1>"; } ?>
            </div>
        </div>
    </div>
    

    <!-- Javascript -->
    <?php Template::get('js'); ?>
</body>
</html>