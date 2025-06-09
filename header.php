<?php
session_start();
include 'admin/koneksi.php';

$jumlah_item = 0;
if (isset($_SESSION['id_user'])) {
    $user_id = $_SESSION['id_user'];
    $query = "SELECT COUNT(*) as total FROM tb_pesanan WHERE id_user = '$user_id'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    $jumlah_item = $data['total'] ?? 0;
}
?>
<a href="cart.php" id="cartlink" style="position: relative; display: inline-block;">
    <i class="fas fa-cart-plus" style="font-size: 16px;"></i>
    <span class="cart-badge"><?= $jumlah_item ?></span>
</a>