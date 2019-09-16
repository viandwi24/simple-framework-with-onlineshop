<?php require_once __DIR__ . '/mod/__load.php'; //load system ?>
<?php
$db = new Database;

$tes = $db->query("SELECT * FROM transaksi t 
                    JOIN transaksi_product tp ON t.id=tp.transaksi_id 
                    LEFT OUTER JOIN product p ON p.id=tp.product_id
                    ", true, PDO::FETCH_OBJ);
dd($tes);