<?php
include "koneksi.php";
$id = $_GET['id'];

$hapus = mysqli_query($koneksi, "DELETE FROM tb_kategori WHERE id_kategori =  '$id'");

if($hapus){
    echo "<script>alert('data berhasil dihapus! ')</script>";
    header("refresh:0, kategori.php");
}else{
    echo "<script>alert('data gagal dihapus!')</script>";
    header("refresh:0, kategori.php");
}
?>