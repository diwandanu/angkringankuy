<?php
session_start();

$username = $_SESSION['username'];

// ambil data di URL
$id_pesanan = $_GET["id_pesanan"];

require 'function.php';
$detail_pesanan = query("SELECT * FROM tb_sub_pesanan JOIN tb_menu ON tb_sub_pesanan.id_produk=tb_menu .id_produk
WHERE tb_sub_pesanan.id_pesanan='$_GET[id_pesanan]'");

$pesanan = query("SELECT * FROM tb_pesanan WHERE id_pesanan='$_GET[id_pesanan]'");
$profil  = query("SELECT * FROM tb_pesanan JOIN tb_user ON tb_pesanan.id_user=tb_user.id_user WHERE id_pesanan='$_GET[id_pesanan]'");

$totalbelanja = 0;

// if ($_SESSION['level'] !== "admin") {
//   header("location: logout.php");
// } else {
// }

if (isset($_POST["confirm"])) {
  if (konfirmasi($_POST) > 0) {
      $_SESSION['id_pesanan'] = $id_pesanan;
      echo "<script>
              alert('Pembayaran Berhasil Dikonfirmasi');
              document.location.href='mailinvoice.php';
          </script>
      ";
  } else {
      echo "<script>
      alert('Pembayaran Gagal Dikonfirmasi');
      document.location.href='daftar_pesanan.php';
  </script>
  ";
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.83.1">
  <title>Dashboard Admin</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">

  <!-- Bootstrap core CSS -->
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
              <a class="nav-link" href="daftar_produk.php">
                Daftar Produk
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="daftar_pesanan.php">
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
            <h2 class="text-center"><b>Detail Data Pesanan Pembeli</b></h2>
        </div>

        <table>
        <?php foreach ($profil as $isi_profil) : ?>
          <tr>
            <td style="width: 50%;"><b>ID Pesanan</b></td>
            <td><b>: <?=$isi_profil["id_pesanan"]?></b></td>
          </tr>
          <tr>
            <td>Nama Pembeli</td>
            <td>: <?=$isi_profil["nama"]?></td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>: <?=nl2br($isi_profil["alamat"])?></td>
          </tr>
          <tr>
            <td>No. Telp</td>
            <td>: <?=$isi_profil["no_telp"]?></td>
          </tr>
          <tr>
            <td>Email</td>
            <td>: <?=$isi_profil["email"]?></td>
          </tr>
          <?php endforeach; ?>
        </table>
        <br>
        <table class="table table-bordered" id="example">
        <thead class="thead-light">
          <tr>
            <th scope="col" style="width: 5%;">No.</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Subharga</th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        <?php foreach ($detail_pesanan as $row) : ?>
        <?php $subharga1=$row['harga_produk']*$row['jumlah']; ?>
          <tr>
            <td><?= $i; ?></td>
            <td><?= $row["nama_produk"]; ?></td>
            <td>Rp. <?= number_format($row['harga_produk']);?></td>
            <td><?= $row["jumlah"]; ?></td>
            <td>Rp. <?= number_format($row['harga_produk']*$row['jumlah']);?></td>
          </tr>
        <?php $i++; ?>
        <?php $totalbelanja+=$subharga1; ?>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="4">Total Bayar</th>
          <th>Rp. <?= number_format($totalbelanja) ?></th>
        </tr>
      </tfoot>
        </table>

        <?php foreach ($pesanan as $status) : ?>
        <?php if($status["pembayaran"] !== "Belum Dibayar") {?>
        <?php if($status["konfirmasi"] == "0") {?>
        <form action="" method="post" enctype="multipart/form-data">
          <a class="btn btn-secondary" href="daftar_pesanan.php">Kembali</a>
          <!-- Button trigger modal -->
          <!-- Trigger the modal with a button -->
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Konfirmasi Pembayaran</button>

          <!-- Modal -->
          <div id="myModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Konfirmasi</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <p style="text-align: center;">Apakah Kamu Ingin Konfirmasi Pembayaran Ini? </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                      <button type="submit" name="confirm" class="btn btn-primary">Yakin</button>
                    </div>
                  </div>
              </div>
          </div>
          <input type="hidden" name="id_pesanan" id="id_pesanan" class="form-control" value="<?= $id_pesanan?>">
        </form>
        <?php } else {?>
            <h5 style="color: green;">Pembayaran Telah Dikonfirmasi</h5>
            <br>
            <a class="btn btn-secondary" href="daftar_pesanan.php">Kembali</a>
        <?php } ?>
        <?php } ?>
        <?php endforeach; ?>
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