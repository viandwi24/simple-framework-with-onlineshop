<?php require_once __DIR__ . '/mod/__load.php'; //load system ?>
<!doctype html>
<html lang="en">
<head>
    <!-- PageTitle -->
    <title><?= WEB['title']; ?></title>
    <!-- CSS -->
    <?php Template::get('css'); ?>
</head>
<body>
    <!-- Navbar -->
    <?php Template::get('navbar'); ?>

    <!-- Conten -->
    <div class="container mb-5 mt-5">
        <?php Template::get('product'); ?>
    </div>
    
    <!-- Javascript -->
    <?php Template::get('js'); ?>
</body>
</html>