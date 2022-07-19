<?php
session_start();
$username = $_SESSION['username'];

require 'function.php';

// ambil data di URL
$id_produk = $_GET["id_produk"];

// query data stocks berdasarkan id
$menu = query("SELECT * FROM tb_menu WHERE id_produk=$id_produk")[0];

// cek apakah button ubah sudah ditekan
if (isset($_POST["ubah"])) {
    // cek apakah data berhasil diubah atau tidak
    if (ubah_produk($_POST) > 0) {
        echo "<script>
                alert('Produk Berhasil Diubah');
                document.location.href='daftar_produk.php';
            </script>
        ";
    } else {
        echo "<script>
        alert('Produk Gagal Diubah');
        document.location.href='daftar_produk.php';
    </script>
    ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">

    <!-- Bootstrap CSS -->
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>

  <!-- Custom styles for this template -->
  <link href="css/dashboard.css" rel="stylesheet">

  <title>Ubah Produk</title>
</head>
<body>
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="daftar_produk.php">Angkringan Kuy</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </header>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="daftar_produk.php">
                                Daftar Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="daftar_pesanan.php">
                                Daftar Pesanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="laporan.php">
                                Laporan
                            </a>
                        </li>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Hello, <?= $username ?></span>
                            <a class="link-secondary" href="#" aria-label="Add a new report">
                            </a>
                        </h6>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_ganti_password.php">
                            Ganti Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2 class="text-center"><b>Ubah Produk</b></h2>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_produk" value="<?= $menu["id_produk"]; ?> ">
                    <input type="hidden" name="oldfoto_produk" value="<?= $menu["foto_produk"]; ?> ">

                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="" required autocomplete="off" 
                        onkeypress="return /[a-z ]/i.test(event.key)" value="<?= $menu["nama_produk"]?>">
                    </div>
                    <div class="form-group">
                        <p>Kategori</p>
                        <input type="radio" id="makanan" name="kategori" value="Makanan" required>
                        <label for="makanan">Makanan</label><br>
                        <input type="radio" id="minuman" name="kategori" value="Minuman" required>
                        <label for="minuman">Minuman</label><br>
                    </div>
                    <div class="form-group">
                        <label for="harga_produk">Harga Produk (Rp)</label>
                        <input type="text" name="harga_produk" id="harga_produk" class="form-control" placeholder="" required autocomplete="off" 
                        onkeypress="return /[0-9]/i.test(event.key)" value="<?= $menu["harga_produk"]?>"> 
                    </div>
                    <div class="form-group">
                        <label for="jumlah_produk">Jumlah Produk</label>
                        <input type="number" name="jumlah_produk" id="jumlah_produk" placeholder="" required autocomplete="off" 
                        min="1" value="<?= $menu["jumlah_produk"]?>">
                    </div>
                    <div class=" form-group">
                        <label for="foto_produk">Foto Produk</label>
                        <br>
                        <img src="gambar/<?= $menu['foto_produk']; ?>" width="250" height="150">
                        <br> <br>
                        <input type="file" name="foto_produk" id="foto_produk" placeholder="" autocomplete="off" >
                    </div>
                    <button type="submit" name="ubah" class="btn btn-primary" onclick="return confirm ('Apakah Data Produk Sudah Benar?');">Ubah</button>
                    <a class="btn btn-danger" href="daftar_produk.php">Batal</a>
                </form>
            </main>
        </div>
    </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function() {
    $('#example').DataTable();
    } );
  </script>
  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
  <script src="css/dashboard.js"></script>
</body>
</html>