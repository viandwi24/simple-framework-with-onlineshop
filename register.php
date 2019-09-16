<?php require_once __DIR__ . '/mod/__load.php'; //load system ?>
<?php if(auth()->check()){ redirect(base_url()); } //no require auth ?>
<!doctype html>
<html lang="en">
<head>
    <!-- PageTitle -->
    <title>Register - <?= WEB['title']; ?></title>
    <!-- CSS -->
    <?php Template::get('css'); ?>
</head>
<body>
    <!-- Navbar -->
    <?php Template::get('navbar'); ?>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Full Name</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required autocomplete="usernam" autofocus>
                                </div>
                            </div>
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
                            <div class="form-group row">
                                <label for="re_password" class="col-md-4 col-form-label text-md-right">Re-Password</label>
                                <div class="col-md-6">
                                    <input id="re_password" type="password" class="form-control" name="re_password" required autocomplete="usernam" autofocus>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Javascript -->
    <?php Template::get('js'); ?>
</body>
</html>