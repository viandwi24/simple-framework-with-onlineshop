<?php require_once __DIR__ . '/mod/__load.php'; //load system ?>
<?php if(!auth()->check()){ redirect(url('login.php')); } //require auth ?>
<?php
if (!isset($_GET['page'])) redirect(url('transaction.php?page=create'));
/** action */
$db = new Database;
if(isset($_POST['a']) && $_POST['a'] == 'create') 
{
    /** get all cart */
    $cart      = Keranjang()->get();

    /** make transaksi data */
    $dbTransaksi = $db->table('transaksi');
    $make_transaksi = $dbTransaksi->insert([
        'users_id' => auth()->guard('user')->user()->id,
        'alamat' => $_POST['alamat'],
    ]);
    $transaksi_id = $dbTransaksi->getLastInsertId();

    /** make list product for transaksi */
    foreach($cart as $item)
    {
        $create = $db->table('transaksi_product')->insert([
            'transaksi_id' => $transaksi_id,
            'product_id' => $item->product->id,
            'cost_purchase' => $item->product->cost,
            'stock_purchase' => $item->stock,
        ]);
    }

    /** delete all cart */
    Cookie::set('keranjang', '');
    /** redirect */
    redirect(url('transaction.php?page=list'));
}
?>



<?php if ($_GET['page'] == 'create') { ;?>
<?php
/** check cart */
$keranjang_count    = Keranjang()->count();
$keranjang_all      = Keranjang()->get();
if (count($keranjang_all) != $keranjang_count || $keranjang_count == 0) redirect(url('cart.php'));
?>
<!doctype html>
<html lang="en">
<head>
    <!-- PageTitle -->
    <title>Buat Transaksi - <?= WEB['title']; ?></title>
    <!-- CSS -->
    <?php Template::get('css'); ?>
</head>
<body>
    <!-- Navbar -->
    <?php Template::get('navbar'); ?>

    <div class="container mb-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <h1 class="card-title mb-2">Transaksi</h1>
                <hr class="mb-4">
                

                <!-- identitas -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <form id="transaksi" action="" method="post">
                            <input type="hidden" name="a" value="create">
                            <div class="form-group row">
                                <label for="id" class="col-md-2 col-form-label text-md-right">ID</label>
                                <div class="col-md-9">
                                    <input value="<?= auth()->guard('user')->user()->id; ?>" id="id" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-md-2 col-form-label text-md-right">Nama</label>
                                <div class="col-md-9">
                                    <input value="<?= auth()->guard('user')->user()->name; ?>" id="nama" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-2 col-form-label text-md-right">Alamat</label>
                                <div class="col-md-9">
                                    <input id="alamat" type="text" class="form-control" name="alamat">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                

                <!-- product list -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Barang</h5>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Stock</th>
                                <th>Harga</th>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 0;
                                $total_harga = 0;
                                foreach($keranjang_all as $item) {
                                    $total_harga = $total_harga + ($item->product->cost * $item->stock);
                                    $stock_min = (int) $item->stock-1;
                                    $stock_max = (int) $item->stock+1;
                                ?>
                                <tr>
                                    <td><?= $i+1; ?></td>
                                    <td><?= $item->product->title; ?></td>
                                    <td><?= $item->stock; ?></td>
                                    <td>Rp <?= $item->product->cost; ?></td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-right" style="padding-right: 100px;">
                        <span>
                            <b>Total : </b>
                            Rp <?= $total_harga; ?>
                        </span>
                    </div>
                </div>

                <button onclick="$('form#transaksi').submit();" class="btn btn-block btn-primary shadow-lg mt-4">
                    Buat Transaksi
                </button>

            </div>
        </div>
    </div>

    <!-- Javascript -->
    <?php Template::get('js'); ?>
</body>
</html>



















<?php } else if ($_GET['page'] == 'list') { ?>
<!doctype html>
<html lang="en">
<head>
    <!-- PageTitle -->
    <title>Daftar Transaksi - <?= WEB['title']; ?></title>
    <!-- CSS -->
    <?php Template::get('css'); ?>
</head>
<body>
    <!-- Navbar -->
    <?php Template::get('navbar'); ?>

    <div class="container mb-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">Daftar Transaksi</div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover mb-0">
                            <thead>
                                <th>#</th>
                                <th>Waktu Transaski</th>
                                <th>...</th>
                            </thead>
                            <tbody>
                                <?php $i = 0;foreach($db->table('transaksi')->get() as $item) { $i++;?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $item->created_at ?></td>
                                    <td>
                                        <a href="<?= url('transaction.php?page=detail&id='.$item->id) ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <?php Template::get('js'); ?>
</body>
</html>


























<?php } else if ($_GET['page'] == 'detail') { ?>
<?php $transaksi = $db->table('transaksi')->where('id', $_GET['id'])->first(); ?>
<!doctype html>
<html lang="en">
<head>
    <!-- PageTitle -->
    <title>Detail Transaksi - <?= WEB['title']; ?></title>
    <!-- CSS -->
    <?php Template::get('css'); ?>
</head>
<body>
    <!-- Navbar -->
    <?php Template::get('navbar'); ?>

    <div class="container mb-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-8">

                <h1>Detail Transaksi</h1><hr>
                <!-- identitas -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <form id="transaksi" action="" method="post">
                            <input type="hidden" name="a" value="create">
                            <div class="form-group row">
                                <label for="id" class="col-md-2 col-form-label text-md-right">ID</label>
                                <div class="col-md-9">
                                    <input value="<?= $transaksi->users_id ?>" id="id" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-md-2 col-form-label text-md-right">Nama</label>
                                <div class="col-md-9">
                                    <input value="<?= auth()->guard('user')->user()->name; ?>" id="nama" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="alamat" class="col-md-2 col-form-label text-md-right">Alamat</label>
                                <div class="col-md-9">
                                    <input id="alamat" type="text" class="form-control" name="alamat" value="<?= $transaksi->alamat ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Waktu" class="col-md-2 col-form-label text-md-right">Waktu</label>
                                <div class="col-md-9">
                                    <input id="Waktu" type="text" class="form-control" name="Waktu" value="<?= $transaksi->created_at ?>" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- product list -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Barang</h5>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Stock</th>
                                <th>Harga</th>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 0;
                                $total_harga = 0;
                                $product = $db->query("SELECT * FROM transaksi t 
                                            JOIN transaksi_product tp ON t.id=tp.transaksi_id 
                                            LEFT OUTER JOIN product p ON p.id=tp.product_id", 
                                            [], true, PDO::FETCH_OBJ);
                                foreach($product as $item) { 
                                    $total_harga = $total_harga + ($item->cost_purchase*$item->stock_purchase);
                                ?>
                                <tr>
                                    <td><?= $i+1; ?></td>
                                    <td><?= $item->title ?></td>
                                    <td><?= $item->stock_purchase ?></td>
                                    <td>Rp <?= $item->cost_purchase ?></td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-right" style="padding-right: 100px;">
                        <span>
                            <b>Total : </b>
                            Rp <?= $total_harga; ?>
                        </span>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- Javascript -->
    <?php Template::get('js'); ?>
</body>
</html>
<?php } ?>