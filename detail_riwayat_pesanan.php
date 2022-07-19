<?php  
session_start();
$username = $_SESSION['username'];
$id_user = $_SESSION['id_user'];

require 'function.php';

// ambil data di URL
$id_pesanan = $_GET["id_pesanan"];

$metode = '';

$detail_pesanan = query("SELECT * FROM tb_sub_pesanan JOIN tb_menu ON tb_sub_pesanan.id_produk=tb_menu.id_produk
WHERE tb_sub_pesanan.id_pesanan='$_GET[id_pesanan]'");

$pesanan = query("SELECT * FROM tb_pesanan WHERE id_pesanan='$_GET[id_pesanan]'");

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

if (isset($_POST["confirm"])) {
    if (pembayaran($_POST) > 0) {
        $_SESSION['id_pesanan'] = $id_pesanan;
        echo "<script>
                alert('File telah terkirim');
                document.location.href='mail.php';
            </script>
        ";
    } else {
        echo "<script>
        alert('File gagal dikirim');
        document.location.href='riwayat_pesanan.php';
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
            <th scope="col" style="width: 5%;">No.</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Harga</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Subharga</th>
          </tr>
        </thead>
        <tbody>
        <?php $totalbelanja=0; ?>   
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
    <br>
    <?php foreach ($pesanan as $status) : ?>
    <?php if($status["pembayaran"] == "Belum Dibayar") {?>
    <form action="" method="post" enctype="multipart/form-data">
        <select name="metode" id="metode">
            <option value = "">---Pilih Metode Pembayaran---</option>
            <option value = "ovo">OVO</option>
            <option value = "bca">Transfer Bank (BCA)</option>
        </select>
        <button type="submit" name="pilih" class="btn btn-primary btn-sm">Pilih</button>
        <?php
        if (isset($_POST["pilih"])) {
            $metode = $_POST['metode']; 
        }
        ?>
    </form>
    <?php if ($metode=="ovo") { ?>
        <form action="" method="post" enctype="multipart/form-data">
            <br>
            <p style="text-align: center; color: red;">Harap Lakukan Pembayaran Melalui OVO dan Kirim Bukti Pembayaran</p>
            <div class="container" style="margin-left: 35%;">
                <img src="gambar/ovo.png" style="width: 25%; height:25%;">
                <style>
                    img{
                        width: 300px;
                        height: 300px;
                        display: block;
                        justify-content: center;
                    }
                </style>
                <p style="margin-bottom: 1px">081382232199</p>
                <p>a/n Sri Nurindah Sari</p>
            </div>
            <input type="file" name="bukti" id="bukti" required>
            <input type="hidden" name="id_pesanan" id="id_pesanan" value="<?=$id_pesanan?>">
            <br><br>
            <a class="btn btn-secondary" href="riwayat_pesanan.php">Kembali</a>
                <!-- Button trigger modal -->
                <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Kirim Bukti Pembayaran </button>

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
                                <p style="text-align: center;">Apakah kamu yakin filenya sudah benar? </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                <button type="submit" name="confirm" class="btn btn-primary">Yakin</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <?php } elseif ($metode=="bca"){?>
        <form action="" method="post" enctype="multipart/form-data">
            <br>
            <p style="text-align: center; color: red;">Harap Lakukan Pembayaran Melalui Transfer Bank BCA dan Kirim Bukti Pembayaran</p>
            <div class="container" style="margin-left: 35%;">
                <img src="gambar/bca.png" style="width: 25%; height:25%;">
                <style>
                    img{
                        width: 300px;
                        height: 300px;
                        display: block;
                        justify-content: center;
                    }
                </style>
                <br>
                <p style="margin-bottom: 1px">No. Rek : 12314512312</p>
                <p>a/n Pemilik Angkringan Kuy</p>
            </div>
            <input type="file" name="bukti" id="bukti" required>
            <input type="hidden" name="id_pesanan" id="id_pesanan" value="<?=$id_pesanan?>">
            <br><br>
            <a class="btn btn-secondary" href="riwayat_pesanan.php">Kembali</a>
                <!-- Button trigger modal -->
                <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Kirim Bukti Pembayaran </button>

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
                                <p style="text-align: center;">Apakah kamu yakin filenya sudah benar? </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                <button type="submit" name="confirm" class="btn btn-primary">Yakin</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php } ?>
            <?php } elseif ($status["selesai"] == "1"){?>
                <a class="btn btn-secondary" href="riwayat_pesanan.php">Kembali</a>
                <a class="btn btn-primary" href="rating_produk.php?id_pesanan=<?=$id_pesanan?>">Rating Produk</a>
            <?php } elseif ($status["selesai"] == "0" && $status["konfirmasi"] == "1"){?>
                <a class="btn btn-secondary" href="riwayat_pesanan.php">Kembali</a>
                <a class="btn btn-primary" href="selesai_pesanan.php?id_pesanan=<?=$id_pesanan?>" onclick="return confirm ('Apakah Yakin Ingin Menyelesaikan Pesanan?');">Selesaikan Pesanan</a>
            <?php } else {?>
                <h5 style="color: green;">Pesanan Telah Dibayar</h5>
                <br>
                <a class="btn btn-secondary" href="riwayat_pesanan.php">Kembali</a>
            <?php } ?>
            <?php endforeach; ?>
            <br><br>
              <footer class="py-5">
                  <div class="medium text-center text-muted">Copyright &copy; 2021 - Angkringan Kuy</div>
              </footer>
        </div>
        <input type="hidden" name="id_pesanan" id="id_pesanan" class="form-control" value="<?= $id_pesanan?>">



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