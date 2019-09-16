<?php require_once __DIR__ . '/mod/__load.php'; //load system ?>
<?php auth()->guard('user')->logout(); redirect(url('login.php')); // logout ?>