<?php
$db = new Database();
$db = $db->table('product')->get();
?>

<div class="row">
    <?php  foreach ($db as $item) { ?>
        <div class="col-md-3 mb-3 mb-2">
            <div class="card h-100">
            <div class="labels">
                <div class="label-new bg-<?php echo ($item->stock == 0) ? 'danger' : 'success';?> text-white text-center py-1">
                    <?php echo ($item->stock == 0) ? 'Stock Habis' : 'Dijual';?>
                </div>
            </div>
            <img src="<?php echo url('assets/images/'.$item->image); ?>" alt="">
            <div class="card-body position-relative d-flex flex-column">
                <?php if($item->stock > 0) {?>
                <a href="<?php echo url('cart.php?a=add&id=' . $item->id . '&stock=1'); ?>" class="add-to-cart bg-primary text-white" data-toggle="tooltip" data-placement="left" title="Add To Cart">
                    <i class="fa fa-opencart" aria-hidden="true"></i>
                </a>
                <?php } else { ?>
                <a href="javascript:void();" onclick="alert('Stock Sudah Habis');" class="add-to-cart bg-primary text-white" data-toggle="tooltip" data-placement="left" title="Add To Cart">
                    <i class="fa fa-opencart" aria-hidden="true"></i>
                </a>
                <?php }?>
                <h4 class="text-success">Rp <?php echo $item->cost; ?></h4>
                <h5><?php echo $item->title; ?></h5>
                <a href="product.php?id=<?php echo $item->id;?>" class="btn btn-success btn-block mt-auto">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    Lihat
                </a>
            </div>
            </div>
        </div>
    <?php } ?>
</div>