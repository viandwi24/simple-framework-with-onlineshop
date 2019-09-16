<?php require_once __DIR__ . '/../mod/__load.php'; //load system ?>
<?php if(auth()->guard('admin')->check()){ redirect(url('admin')); } //no require auth ?>
<?php
//action
if(isset($_POST['login']))
{
    $username   = $_POST['username'];
    $password   = $_POST['password'];

    if( auth()->guard('admin')->attempt($username, $password) ) auth()->guard('admin')->login($username);
    redirect(url("admin/login.php"));
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- PageTitle -->
    <title>Login - Admin <?= WEB['title']; ?></title>
    <!-- CSS -->
    <?php Template::get('css'); ?>
</head>
<body>
    <!-- Navbar -->
    <?php Template::get('admin_navbar'); ?>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group row">
                                <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>
                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username" required autocomplete="usernam" autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="usernam" autofocus>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button name="login" type="submit" class="btn btn-primary">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <b>&copy; <?= WEB['c_year']; ?></b>
                        <?= WEB['c_company']; ?>
                        by
                        <b><?= WEB['create_by']; ?></b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Javascript -->
    <?php Template::get('js'); ?>
</body>
</html>