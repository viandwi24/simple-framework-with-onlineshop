<?php require_once __DIR__ . '/mod/__load.php'; ?>
<?php
$product = new Database();
$product = $product->table('product')
    ->where('id', '=', $_GET['id'])
    ->get()[0];
?>
<!doctype html>
<html lang="en">
<head>
    <!-- PageTitle -->
    <title>Beli "<?php echo $product->title; ?>" - <?= WEB['title']; ?></title>
    <!-- CSS -->
    <?php Template::get('css'); ?>
</head>
<body>
    <!-- Navbar -->
    <?php Template::get('navbar'); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div style="width: auto; height: 200px; overflow:hidden;">
                        <img src="<?php echo $product->image; ?>" style="height: 100%; min-width: 100%; left: 50%; position: relative; transform: translateX(-50%);" />
                    </div>
                    <div class="card-header">
                        <h3 class="card-title mb-0"><?php echo $product->title; ?></h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <tr>
                                <th>Nama</th>
                                <td>: <?php echo $product->title; ?></td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>
                                    :
                                    <span class="text-<?php echo ($product->stock == 0) ? 'danger' : 'success'; ?>">
                                        <?php echo ($product->stock == 0) ? 'Stok Habis!' : $product->stock; ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>: Rp <?php echo $product->cost; ?></td>
                            </tr>
                        </table>
                        <div class="text-right p-2">
                            <a href="<?php echo base_url(); ?>" class="btn btn-sm btn-danger">
                                <i class="fa fa-chevron-left"></i>
                                Kembali
                            </a>
                            <a href="" class="btn btn-sm btn-primary">
                                <i class="fa fa-shopping-bag"></i>
                                Tambahkan Ke Keranjang
                            </a>
                            <a href="" class="btn btn-sm btn-success">
                                <i class="fa fa-money"></i>
                                Beli
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <?php Template::get('js'); ?>
</body>
</html>