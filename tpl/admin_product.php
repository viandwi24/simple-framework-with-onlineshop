<?php
$db = new Database;

/** delete */
if(isset($_GET['a']) && $_GET['a'] == 'delete')
{
  if (!isset($_GET['id'])) dd('parameter is missing');
  $id = $_GET['id'];

  $product = $db->table('product')->where('id', $id)->findOrDie('id product isnt valid');
  $delete = $db->table('product')->where('id', $id)->delete();
  redirect(url('admin?page=product'));
}

/** edit */
if(isset($_POST['a']) && $_POST['a'] == 'edit')
{
  $req_param = ['id', 'title', 'stock', 'cost'];
  foreach($req_param as $item)
  {
    if (!isset($_POST[$item])) dd($item . " parameter is missing.");
  }
  $id = $_POST['id'];


  $product = $db->table('product')->where('id', $id)->update([
    'title' => $_POST['title'],
    'stock' => $_POST['stock'],
    'cost' => $_POST['cost'],
  ]);
  
  redirect(url('admin?page=product'));
}

/** new */
if(isset($_POST['a']) && $_POST['a'] == 'tambah')
{
  $req_param = ['title', 'stock', 'cost'];
  foreach($req_param as $item)
  {
    if (!isset($_POST[$item]) || str_replace(' ', '', $_POST[$item]) == '' || $_POST[$item] == null) dd($item . " parameter is missing.");
  }

  $upload = files()->select('image')->mimes(['jpg', 'png', 'jpeg'])->upload([
    'path' => BASE_PATH . 'assets/images'
  ]);
  $image_file = $upload['name'];

  if (!$upload) {
    echo "
      <script>
        alert('gagal mengupload gambar');
        window.location.href = '". url('admin?page=product') ."';
      </script>
    ";
    die('');
  } else {
    $db->table('product')->insert([
      'title' => $_POST['title'],
      'stock' => $_POST['stock'],
      'cost' => $_POST['cost'],
      'image' => $image_file
    ]);
  }
  redirect(url('admin?page=product'));
}

$barang = $db->table('product')->get();
?>
<div class="card">
    <div class="card-header">Produk</div>
    <div class="card-body">
        <div class="mb-3">
          <button onclick="$('#tambahModal').modal('show');" class="btn btn-success btn-sm">Tambah</button>
        </div>
        <table class="table table-hover">
            <thead>
                <th>#</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stock</th>
                <th>
                    ...
                </th>
            </thead>
            <tbody>
                <?php $i = 0; foreach($barang as $item) { $i++; ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $item->title; ?></td>
                        <td>Rp <?= $item->cost; ?></td>
                        <td><?= $item->stock; ?></td>
                        <td>
                            <button onclick='edit(<?= json_encode($item); ?>);' class="btn btn-sm btn-warning">Edit</button>
                            <button onclick="window.location.href='<?= url('admin?page=product&a=delete&id=' . $item->id); ?>';" class="btn btn-sm btn-danger">Hapus</ onclick="window.location.href='<?= url('admin?page=product&a=delete&id=' . $item->id); ?>';">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="eForm" method="POST">
            <input type="hidden" name="id" id="eId">
            <input type="hidden" name="a" id="eAction" value="edit">
            <div class="form-group">
                <label>Judu</label>
                <input id="eTitle" type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input id="eCost" type="number" class="form-control" name="cost">
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input id="eStock" type="number" class="form-control" name="stock">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="tForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="a" id="eAction" value="tambah">
            <div class="form-group">
                <label>Judu</label>
                <input id="tTitle" type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input id="tCost" type="number" class="form-control" name="cost">
            </div>
            <div class="form-group">
                <label>Stok</label>
                <input id="tStock" type="number" class="form-control" name="stock">
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input id="tImage" type="file" class="form-control" name="image">
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function edit(data) {
  $('#exampleModal').modal('show');
  $('form#eForm #eId').val(data.id);
  $('form#eForm #eTitle').val(data.title);
  $('form#eForm #eCost').val(data.cost);
  $('form#eForm #eStock').val(data.stock);
}
</script>