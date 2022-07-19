<?php 
    session_start();
    require 'function.php';
    $id_pesanan = $_GET['id_pesanan'];
    $selesai = 1;

    $query = "UPDATE tb_pesanan SET selesai = $selesai WHERE id_pesanan='$id_pesanan'";

    mysqli_query($conn, $query);

    echo "<script>
        alert('Pesanan Telah Diselesaikan, Sekarang Anda Bisa Melakukan Rating Produk');
        document.location.href='detail_riwayat_pesanan.php?id_pesanan=$id_pesanan';
    </script>";
?>