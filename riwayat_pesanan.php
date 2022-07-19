<?php  
session_start();
$username = $_SESSION['username'];
$id_user = $_SESSION['id_user'];

require 'function.php';

$pesanan = query("SELECT * FROM tb_pesanan WHERE id_user='$id_user'");


if(!isset($_SESSION['level'])) {
    header("location: login.php");
    }else{



if(empty($_SESSION["pesanan"]))
{
    $jml_keranjang = 0;
}
    else{
    $jml_keranjang = 0;    
    foreach ($_SESSION["pesanan"] as $id_produk) :
        $jml_keranjang++;
    endforeach;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <script src="https://kit.fontawesome.com/5be3928c9f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Riwayat Pesanan</title>
  </head>
  <body>

    <!-- Navigation Bar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent" id="MainNav">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php" style="color : white;">
                    <i class="fas fa-store-alt"></i>
                    Angkringan Kuy
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="index.php">Home</span></a>
                        </li>
                        <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" href="">Kategori</a>
                          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <li>
                                <a class="dropdown-item" href="makanan.php">
                                    Makanan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="minuman.php">
                                    Minuman
                                </a>
                            </li>
                          </ul>
                        </li>
                        <?php
                        if(!isset($_SESSION['level'])) {
                            ?>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="registrasi.php">Registrasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="login.php">Login</a>
                        </li>
                        <?php } else {?>
                            <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="keranjang.php">
                                Keranjang
                                <?php
                                    if(empty($_SESSION["pesanan"]))
                                    {
                                        $jml_keranjang = 0;
                                    }
                                    else{
                                ?>
                                    <span class="icon-button__badge"><?= $jml_keranjang ?></span>
                                <?php } ?>
                            </a>                        
                        </li>

                        <li class="nav-item active">
                            <a class="nav-link js-scroll-trigger" href="riwayat_pesanan.php">Riwayat Pesanan</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" href="">
                            Profil Anda                            
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="kelola_akun.php?id_user=<?= $id_user ?>">
                                        Kelola Akun
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="logout.php">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>   
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <div class="container bg-light">
    <h3 class="text-center"><b>RIWAYAT PESANAN ANDA</b></h3>
    <table class="table table-bordered" id="example">
        <thead class="thead-light">
          <tr>
            <th>No.</th>
            <th>ID Pesanan</th>
            <th>Tanggal Pemesanan</th>
            <th>Total Harga</th>
            <th>Status Pemesanan</th>
            <th>Pembayaran</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        <?php foreach ($pesanan as $row) : ?>
          <tr>
            <td><?= $i; ?></td>
            <td><?= $row["id_pesanan"]; ?></td>
            <td><?= tanggal_indonesia(date('N j/n/Y H:i', strtotime($row['tanggal_pemesanan']))); ?></td>
            <td><?= $row["total_harga"]; ?></td>
            <td><?= $row["status_pemesanan"]; ?></td>
            <td>
              <?php if($row["pembayaran"] !== "Belum Dibayar") {?>
              Telah Dibayar  
              <?php } else {?>
              Belum Dibayar
              <?php } ?>
            </td>
            <td> 
              <a href="detail_riwayat_pesanan.php?id_pesanan=<?= $row['id_pesanan']?>">Detail</a> 
              <?php if($row["pembayaran"] == "Belum Dibayar") {?>
              | 
              <a href="hapus_pesanan.php?id_pesanan=<?= $row['id_pesanan']?>" 
              onclick="return confirm ('Riwayat Pesanan Ini Akan Dihapus, Apakah Kamu Yakin?');">Hapus</a> 
              <?php } ?>
            </td>
          </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
        </tbody>
        </table><br>
        <br><br><br><br><br><br><br><br>
      
      
          <footer class="py-5">
              <div class="medium text-center text-muted">Copyright &copy; 2021 - Angkringan Kuy</div>
          </footer>
    </div>
        



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
      $(document).ready(function() {
          $('#example').DataTable();
      } );
    </script>
  </body>
</html>
<?php } ?>