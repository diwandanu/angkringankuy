<?php 
session_start();
require 'function.php';
$id_pesanan = $_GET['id_pesanan'];

$sub_pesanan = query("SELECT * FROM tb_sub_pesanan WHERE id_pesanan='$id_pesanan'");

foreach ($sub_pesanan as $row)
{
    $id_produk = $row['id_produk'];

    $pilih_stok_tb_menu = mysqli_query($conn, "SELECT jumlah_produk as stok from tb_menu WHERE id_produk = '$id_produk'");
    $cek_pilih_stok_tb_menu = mysqli_fetch_array($pilih_stok_tb_menu);
    $stok = $cek_pilih_stok_tb_menu['stok'];

    $pilih_stok = mysqli_query($conn, "SELECT jumlah as jumlah_beli from tb_sub_pesanan WHERE id_produk = '$id_produk' AND id_pesanan = '$id_pesanan'");
    $cek_pilih_stok = mysqli_fetch_array($pilih_stok);
    $data_stok_produk = $cek_pilih_stok['jumlah_beli'];
    $total_asli = $data_stok_produk + $stok;

    $ubah_stok = "UPDATE tb_menu SET jumlah_produk = $total_asli WHERE id_produk = '$id_produk'";
    mysqli_query($conn, $ubah_stok);
    
}
 
$hapus= mysqli_query($conn, "DELETE FROM tb_pesanan WHERE id_pesanan='$id_pesanan'");


if($hapus){
    $hapus_sub_pesanan= mysqli_query($conn, "DELETE FROM tb_sub_pesanan WHERE id_pesanan='$id_pesanan'");
    echo "<script>
        alert('Riwayat Pesanan Telah Dihapus');
        document.location.href='riwayat_pesanan.php';
    </script>";
} else
    echo "<script>
        alert('Riwayat Pesanan Gagal Dihapus');
        document.location.href='riwayat_pesanan.php';
    </script>";
?>