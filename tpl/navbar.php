<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo base_url();?>"><?= WEB['title']; ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <!-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> -->
      </li>
    </ul>
    <ul class="navbar-nav">
        <?php if(Auth()->guard('user')->check()) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo url('transaction.php?page=list'); ?>"><i class="fa fa-money"></i> Transaksi</a>
          </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo url('cart.php'); ?>">
            <i class="fa fa-shopping-bag"></i>
            Keranjang
            <?php if(Cookie::get('keranjang') != null) { ?>
              <span class="badge badge-primary">
                <?php echo Keranjang()->count(); ?>
              </span>
            <?php } ?>
          </a>
        </li>
        <?php if(Auth()->guard('user')->check()) { ?>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user"></i>
                  <?= Auth()->guard('user')->user()->name; ?>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <!-- <div class="dropdown-divider"></div> -->
              <a class="dropdown-item" href="<?= url('logout.php'); ?>">Logout</a>
              </div>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= url('register.php'); ?>">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-primary btn-sm text-white" href="<?= url('login.php'); ?>">
              <i class="fa fa-sign-in"></i>
              Login
            </a>
          </li>
        <?php } ?>
    </ul>
  </div>
</nav>