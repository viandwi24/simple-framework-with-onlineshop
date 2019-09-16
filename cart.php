<?php require_once __DIR__ . '/mod/__load.php'; //load system ?>
<?php
$db = new Database;
/** action */
if(isset($_GET['a']))
{
    switch($_GET['a'])
    {
        case 'add':
            $id     = isset($_GET['id']) ? $_GET['id'] : dd("id paramater is required");
            $stock  = isset($_GET['stock']) ? $_GET['stock'] : 1;
            $cart_add = keranjang()->add($id, $stock);
            if(!$cart_add) {
                dd("<script>alert('gagal menambahkan ke keranjang.');
                window.location.href='".url('cart.php')."';
                </script>");
            }
            redirect(url('cart.php'));
            break;
        
        case 'stok':
            $id     = isset($_GET['id']) ? $_GET['id'] : dd("id paramater is required");
            $stock  = isset($_GET['val']) ? $_GET['val'] : 1;
            $cart_change = keranjang()->change($id, $stock);
            if(!$cart_change) {
                dd("<script>alert('gagal mengubah keranjang.');
                window.location.href='".url('cart.php')."';
                </script>");
            }
            redirect(url('cart.php'));
            break;

        case 'delete':
            $id     = isset($_GET['id']) ? $_GET['id'] : dd("id paramater is required");
            $cart_change = keranjang()->delete($id);
            if(!$cart_change) {
                dd("<script>alert('gagal mengubah keranjang.');
                window.location.href='".url('cart.php')."';
                </script>");
            }
            redirect(url('cart.php'));
            break;
    }
}


$keranjang_count    = Keranjang()->count();
$keranjang_all      = Keranjang()->get();
if (count($keranjang_all) != $keranjang_count) redirect(url('cart.php'));
?>
<!doctype html>
<html lang="en">
<head>
    <!-- PageTitle -->
    <title>Keranjang - <?= WEB['title']; ?></title>
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
                    <div class="card-header">
                        <h2 class="card-title mb-0">
                            Keranjang
                            <span class="badge badge-primary">
                                <?= $keranjang_count; ?>
                            </span>
                        </h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Stock</th>
                                <th>Harga</th>
                                <th>...</th>
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
                                    <td><?php echo $i+1; ?></td>
                                    <td><?php echo $item->product->title; ?></td>
                                    <td>
                                        <a href="<?= url('cart.php?a=stok&val='.$stock_min.'&id='.$item->product->id); ?>" class="btn-sm btn-danger">-</a>
                                        <input type="text" name="val" value="<?php echo $item->stock; ?>" style="width: 40px;text-align:center;" readonly>
                                        <a href="<?= url('cart.php?a=stok&val='.$stock_max.'&id='.$item->product->id); ?>" class="btn-sm btn-primary">+</a>
                                    </td>
                                    <td>Rp <?php echo $item->product->cost; ?></td>
                                    <td>
                                        <a href="<?= url('cart.php?a=delete&id='.$item->product->id) ?>" class="btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                                <tr>
                                    <th>Total</th>
                                    <td colspan="2">:</td>
                                    <td colspan="2">Rp <?php echo $total_harga; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-right">
                            <?php function e($txt){ return $txt; } ?>
                            <a <?= auth()->guard('user')->check() ? 
                                ($keranjang_count > 0 ? 'href="'.url('transaction.php').'"' : 'onclick="'.e("alert('tidak ada barang dikeranjang');").'" href="javascript:void()" ')
                             : 'onclick="'.e("alert('harus login');").'" href="javascript:void()" '; ?> class="btn btn-sm btn-primary">Bayar Sekarang</a>
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