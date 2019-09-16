<?php require_once __DIR__ . '/../mod/__load.php'; //load system ?>
<?php auth()->guard('admin')->logout(); redirect(url('admin/login.php')); // logout ?>