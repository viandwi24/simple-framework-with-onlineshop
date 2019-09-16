<?php
$db = new Database;

if (isset($_GET['a']) && $_GET['a'] == 'del')
{
    if (!isset($_GET['id'])) dd("id parameter is required");
    $del = $db->table('transaksi')->where('id', $_GET['id'])->delete();
    if (!$del) {
        dd("<script>alert('gagal menghapus transaksi.');
        window.location.href='".url('cart.php')."';
        </script>");
    }
    redirect(url('admin?page=transaction'));
}


$te = $db->query("SELECT t.id as id, u.id as users_id, u.name as users_name, t.created_at, t.alamat
                    FROM transaksi t JOIN users u ON u.id=t.users_id"
                    , [], true);
?>
<div class="card">
    <div class="card-header">Transaksi</div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <th>#</th>
                    <th>User</th>
                    <th>Waktu</th>
                    <th>...</th>
                </thead>
                <tbody>
                    <?php $i=1; foreach($te as $item) { ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $item->users_name ?></td>
                            <td><?= $item->created_at ?></td>
                            <td>
                                <button onclick='detail(<?= json_encode($db->query("SELECT *, t.id as transaksi_id FROM transaksi t JOIN transaksi_product tp ON t.id=tp.transaksi_id LEFT OUTER JOIN product p ON p.id=tp.product_id WHERE t.id=" . $item->id, [], true, PDO::FETCH_OBJ)) ?>, <?= json_encode($item) ?>)' class="btn btn-sm btn-warning">Detail</button>
                                <a href="<?= url('admin?page=transaction&a=del&id='.$item->id) ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form">
              <div class="form-group">
                  <label>User ID</label>
                  <input type="text" id="dUserId" class="form-control" readonly>
              </div>
              <div class="form-group">
                  <label>Nama User</label>
                  <input type="text" id="dUserName" class="form-control" readonly>
              </div>
              <div class="form-group">
                  <label>Alamat</label>
                  <input type="text" id="dAlamat" class="form-control" readonly>
              </div>
              <div class="form-group">
                  <label>Waktu Memesan</label>
                  <input type="text" id="dWaktu" class="form-control" readonly>
              </div>

              <hr>
              <table class="table table-hover mb-0">
                <thead>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Stock</th>
                    <th>Harga</th>
                </thead>
                <tbody id="list-barang">

                </tbody>
              </table>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal"  class="btn btn-primary">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
    function detail(data, transaksi) {
        $('#exampleModal').modal('show');
        $('#exampleModal #dUserId').val(transaksi.users_id);
        $('#exampleModal #dUserName').val(transaksi.users_name);
        $('#exampleModal #dAlamat').val(transaksi.alamat);
        $('#exampleModal #dWaktu').val(transaksi.created_at);
        $('#exampleModal #list-barang').html('');
        let i = 0;
        let total = 0;
        data.forEach(item => {
            total = total + (item.stock_purchase * item.cost_purchase);
            i++;
            barang = $('<tr>'
            + '<td>' + i + '</td>'
            + '<td>' + item.title + '</td>'
            + '<td>' + item.stock_purchase + '</td>'
            + '<td>' + item.cost_purchase + '</td>'
            + '</tr>');
            $('#exampleModal #list-barang').append(barang);
        });
        $('#exampleModal #list-barang').append('<tr>'
        + '<th>Total</th>'
        + '<td colspan="2">:</td>'
        + '<td colspan="2">Rp ' + total + '</td>'
        + '</tr>');
    }
</script>